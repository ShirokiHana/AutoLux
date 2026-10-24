<?php

use core\SessionHelper;

    $merge = mergeCartState( SessionHelper::get( 'restockCart' ), 'restockCart' );
    $merge( $request );

    SessionHelper::flashInit( 'old', $request );
    postRedirectGet( 'management/order/cart?supplier_id=' . $request[ 'supplier_id' ] );