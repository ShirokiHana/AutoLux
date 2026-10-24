<?php

    use core\SessionHelper;

    $partId = $request[ 'id' ];
    $cart = SessionHelper::get( 'restockCart' );

    $remainingCart = array_filter(
        $cart,
        fn( array $item ) => ( int ) $item[ 'part_id' ] !== $partId
    );

    SessionHelper::set( 'restockCart', $remainingCart );
    postRedirectGet( 'management/order/cart?supplier_id=' . $request[ 'supplier_id' ] );