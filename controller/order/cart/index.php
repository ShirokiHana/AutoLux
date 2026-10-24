<?php

use core\CartHelper;
use core\Database;

    // Add to cart rendering - SINGLE SOURCE OF TRUTH
    $options = [ 'part_id', 'part_type', 'brand', 'part_name' ];

    $spread = implode( ', ', $options );
    $parts = Database::fetch( 'All', "SELECT $spread FROM parts" );

    view( 'order/cart/index.view.php', 'basePath', [
        // Add to cart rendering
        'parts' => $parts,
        // Cart rendering
        'cart' => CartHelper::getCartState(),
        'cartOptions' => CartHelper::getRenderingOptions( $options ),
    ] );