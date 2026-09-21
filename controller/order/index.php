<?php

use core\Database;

    $parts = Database::fetchAll( 'SELECT part_type, brand, part_name FROM parts' );
    $payment = Database::fetchAll( 'SELECT method_name FROM payment_methods' );
    $clients = Database::fetchAll( 'SELECT client_name FROM clients' );
    $options = [ 'part_type', 'brand', 'part_name' ];

    // TODO: $cart is no longer required, calculate state out of place within proper scope.
    $cart = [];

    view( 'order/index.view.php', 'basePath', [
        'clients' => $clients,
        'parts' => $parts,
        'cart' => $cart,
        'options' => $options,
        'payment' => $payment
    ] );