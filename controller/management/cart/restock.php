<?php
    use core\Database;
    use core\NodeClient;
    use core\SessionHelper;
    use lib\FnArray;

    screen( $request );

try {

        $TEST_MODE = false;

        if ( $TEST_MODE ) {

            $supplierId = 1;
            $items = [
                [ 'part_id' => 1, 'quantity' => 2 ],
            ];

        } else {

            $supplierId = ( int ) ( $request[ 'supplier_id' ] ?? 0 );
            $items = FnArray::map(
                $request[ 'restock' ] ?? [],
                fn( $element ) => [
                    'part_id' => ( int ) $element[ 'part_id' ],
                    'quantity' => ( int ) $element[ 'quantity' ],
                ]
            );

        }


        if ( $supplierId <= 0 || $items === [] ) {
            throw new Exception('Invalid supplier order');
        }

        // create supplier_order in node
        $response = NodeClient::request('POST', '/order',
                [
                    'supplier_id' => $supplierId,
                    'items' => $items,
                ]
            );

        $orderId = ( int )( $response['order_id'] ?? 0 );
        if ( $orderId <= 0 )
            throw new Exception('Invalid supplier order response');

        // idempotency guard
        $existing = Database::fetch(
            'Single',
            'SELECT node_order_id FROM supplier_order_sync WHERE node_order_id = ?',
            [ $orderId ]
        );

        if ( !$existing ) {
            // fetch items from node order
            $orderItems = NodeClient::request('GET', "/order/$orderId/items") ?? [];

            if ( !is_array( $orderItems ) || $orderItems === [] )
                throw new Exception('Unable to load supplier order items');

            // stock update, sync db
            Database::runTransaction( function() use ( $orderId, $orderItems ) {

                FnArray::map(
                    $orderItems,
                    function( $item ) {
                        $partId = ( int ) ( $item[ 'part_id' ] ?? 0 );
                        $quantity = ( int ) ( $item[ 'quantity' ] ?? 0 );

                        if ( $partId <= 0 || $quantity <= 0 )
                            throw new Exception( 'Something went wrong, please try again' );

                        $affected = Database::pushData(
                            'UPDATE parts SET stock_quantity = stock_quantity + :quantity WHERE part_id = :part_id',
                            [
                                'quantity' => $quantity,
                                'part_id' => $partId,
                            ]
                        );

                        if ( $affected !== 1 ) {
                            throw new Exception("Unable to restock part #$partId");
                        }
                    }
                );

                Database::pushData(
                    'INSERT INTO supplier_order_sync ( node_order_id, stock_applied_at ) VALUES ( ?, NOW() )',
                    [ $orderId ]
                );
            } );
        }

        try {
            NodeClient::request( 'PATCH', '/order/' . $orderId, [
                'status' => 'received',
            ] );

            Database::pushData(
                'UPDATE supplier_order_sync SET status_synced_at = NOW(), sync_error = NULL WHERE node_order_id = ?',
                [ $orderId ]
            );

        } catch ( Throwable $exception ) {

            Database::pushData(
                'UPDATE supplier_order_sync SET sync_error = ? WHERE node_order_id = ?',
                [ $exception->getMessage(), $orderId ]
            );

            SessionHelper::flashInit( 'errors', [
                'restock-sync' => 'Status sync failed.',
            ]);
        }

        // if already applied previously avoid double increment
        SessionHelper::flashInit( 'restock', [
            'supplier_id' => $supplierId,
            'order_id' => $orderId,
            'items' => $items,
        ] );
        postRedirectGet('management/order/confirmation');

    } catch ( Throwable $exception ) {
        SessionHelper::flashInit('errors', [
            'restock' => $exception->getMessage(),
        ] );

        $fallbackSupplier = ( int ) ( $request[ 'supplier_id' ] ?? 0 );
        $query = $fallbackSupplier > 0
            ? '?supplier_id=' . $fallbackSupplier
            : '';

        postRedirectGet('management/order/cart' . $query);
    }