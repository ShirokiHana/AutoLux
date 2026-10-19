<?php

use core\payment\PaymentMethod;
use core\CartHelper;
use core\Database;
use lib\FnArray;

// 1 -> VISA, 2 -> MasterCard, 3 -> MBWay

    // Payment options rendering
    $payment = Database::fetch( 'All', 'SELECT payment_method_id, method_name FROM payment_methods' );

    $requested = strtoupper( $request[ 'payment_method' ] ?? '' );

    // Fall back to the first method when the param is missing or unknown
    $match = FnArray::filter( $payment, fn( $p ) => strtoupper( $p[ 'method_name' ] ) === $requested );
    $selected = reset( $match ) ?: $payment[ 0 ];

    $payment_method = $selected[ 'method_name' ];
    $payment_id = (int) $selected[ 'payment_method_id' ];

    view( 'order/payment/index.view.php', 'basePath', [
        // Cart rendering
        'cart' => CartHelper::getCartState(),
        'cartOptions' => CartHelper::getDefaultRenderingOptions(),
        // Payment options rendering
        'payment' => $payment,
        'payment_method' => PaymentMethod::output( $payment_id ),
    ] );