<?php

use core\Database;

// Add to cart rendering - SINGLE SOURCE OF TRUTH
$options = [ 'part_type', 'brand', 'part_name' ];

$spread = implode( ', ', $options );
$parts = Database::fetchAll( "SELECT $spread FROM parts" );

// Cart rendering
// TODO: $cart is no longer required, calculate state out of place within proper scope. ✅
$cart = $_SESSION[ 'cart' ] ?? [];
$cartOptions = array_merge( $options, [ 'quantity' ] );

view( 'order/cart/index.view.php', 'basePath', [
    // Add to cart rendering
    'parts' => $parts,
    'options' => $options,
    // Cart rendering
    'cart' => $cart,
    'cartOptions' => $cartOptions,
] );