<?php

    use core\SessionHelper;

    $partId = $request[ 'part_id' ];
    $cart = SessionHelper::get( 'cart' );

    $remainingCart = array_filter(
        $cart,
        fn( array $item ) => ( int ) $item[ 'part_id' ] !== $partId
    );

    SessionHelper::set( 'cart', $remainingCart );
    postRedirectGet( 'order/cart' );