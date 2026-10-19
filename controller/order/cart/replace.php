<?php

use core\SessionHelper;

    $merge = mergeCartState( SessionHelper::get( 'cart' ) );
    $merge( $request );

    SessionHelper::flashInit( 'old', $request );
    postRedirectGet( 'order/cart' );