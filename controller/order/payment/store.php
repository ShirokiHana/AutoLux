<?php

use core\payment\PaymentMethod;
use core\SessionHelper;
use core\CartHelper;
use core\Database;
use lib\FnArray;

    // Check inventory
    $paramsOrder = [
        'client_id' => SessionHelper::get( 'client' )[ 0 ],
        'payment_method_id' => $request[ 'method-id' ],
    ];

    $cart = FnArray::map( CartHelper::getCartState(),
        fn( $element ) => [ ...$element, 'unit_price' => CartHelper::fetchPartPrice( $element[ 'part_id' ] ) ]
    );

    // Link items to order

    try {
        $id = Database::runTransaction( function() use ( $paramsOrder, $cart ) {
            Database::checkInventory( $cart );

            Database::pushData(
                'INSERT INTO orders ( client_id, payment_method_id ) VALUES ( :client_id, :payment_method_id )',
                $paramsOrder
            ) === 1 || throw new RuntimeException( 'Unable to create order, please try again later' );

            $orderId = Database::getLastInsertedId();

            FnArray::map( $cart, fn( $element ) => Database::pushData(
                'INSERT INTO order_items ( order_id, part_id, quantity, unit_price ) VALUES ( :order_id, :part_id, :quantity, :unit_price )',
                [
                    'order_id' => $orderId,
                    'part_id' => $element[ 'part_id' ],
                    'quantity' => $element[ 'quantity' ],
                    'unit_price' => $element[ 'unit_price' ],
                ]
            ) === 1 || throw new RuntimeException( 'Unable to complete order, please try again later' ) );

            return $orderId;
        } );
    } catch ( Throwable $exception ) {
        if ( $exception->getMessage() !== 'Missing stock' )
            /** @noinspection PhpUnhandledExceptionInspection */
            throw $exception;

        SessionHelper::flashInit( 'errors', [
            'payment' => 'One or more items are no longer available in the requested quantity.',
        ] );
        postRedirectGet( 'order/payment?payment_method=' . urlencode( $request[ 'method-name' ] ) );
    }

    // Flash receipt
    $client = Database::fetch(
        'Single',
        'SELECT client_name FROM clients WHERE client_id = ?',
        [ $paramsOrder[ 'client_id' ] ]
    );

    SessionHelper::flashInit( 'receipt', [
        'order_id' => $id,
        'client_name' => $client[ 'client_name' ],
        'payment_name' => PaymentMethod::output( $paramsOrder[ 'payment_method_id' ] )->getPaymentName(),
    ] );

    // Redirect
    postRedirectGet( 'order/confirmation' );