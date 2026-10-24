<?php

use core\SessionHelper;

    screen( SessionHelper::get( 'cart' ) );

    $merge = mergeCartState( SessionHelper::get( 'cart' ) );
    $merge( $request );

    SessionHelper::flashInit( 'old', $request );
    postRedirectGet( 'order/cart' );