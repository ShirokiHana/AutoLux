<?php


use core\Database;
use core\SessionHelper;

    try {
        Database::runTransaction( function() use ( $request ) {
            foreach( $request[ 'restock' ] as $item ) {
                Database::pushData(
                    'UPDATE parts SET stock_quantity =  stock_quantity + :quantity WHERE part_id = :part_id',
                    [ 'quantity' => $item[ 'quantity' ], 'part_id' => $item[ 'part_id' ] ]
                ) > 0 || throw new Exception( "Unknown part #{$item[ 'part_id' ]}" );
            }
        } );
    } catch ( Throwable $exception ) {
        SessionHelper::flashInit( 'errors', [ 'restock' => $exception->getMessage() ] );
        postRedirectGet( 'management/order/cart?supplier_id=' . $request[ 'supplier_id' ] );
    }

    SessionHelper::flashInit( 'restock', [
        'supplier_id' => $request[ 'supplier_id' ],
        'items' => $request[ 'restock' ],
    ] );

    postRedirectGet( 'management/order/confirmation' );