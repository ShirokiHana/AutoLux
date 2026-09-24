<?php

use core\Database;

// Client dropdown rendering
$clients = Database::fetchAll( 'SELECT client_name FROM clients' );

// Add to cart rendering - SINGLE SOURCE OF TRUTH
$options = [ 'part_type', 'brand', 'part_name' ];

$spread = implode( ', ', $options );
$parts = Database::fetchAll( "SELECT $spread FROM parts" );

// Cart rendering
// TODO: $cart is no longer required, calculate state out of place within proper scope. ✅
$cart = $_SESSION[ 'cart' ] ?? [];
$cartOptions = array_merge( $options, [ 'quantity' ] );

// Payment options rendering
$payment = Database::fetchAll( 'SELECT method_name FROM payment_methods' );

view( 'order/index.view.php', 'basePath', [
    // Client dropdown rendering
    'clients' => $clients,
    // Add to cart rendering
    'parts' => $parts,
    'options' => $options,
    // Cart rendering
    'cart' => $cart,
    'cartOptions' => $cartOptions,
    // Payment options rendering
    'payment' => $payment
] );