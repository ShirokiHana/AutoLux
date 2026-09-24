<?php
    use core\Database;

    // Store user to DB
    $params = [
        'client_name' => $request[ 'new-client-name' ],
        'email' => $request[ 'new-client-email' ],
        'phone' => $request[ 'new-client-phone' ]
    ];

    Database::pushData( 'INSERT INTO clients ( client_name, email, phone ) VALUES ( :client_name, :email, :phone )', $params );

    // Redirect to replace to session
    postRedirectGet( 'order' );