<?php
    use core\Database;
    use core\SessionHelper;

    $id = $request[ 'id' ];

    $client = Database::fetch( 'Single', 'SELECT client_id FROM clients WHERE client_id = :id', [ 'id' => $id ] );

    if ( !$client )
        throw new Exception( 'Client not found', 404 );

    Database::pushData(
        'UPDATE clients SET client_name = :name, email = :email, phone = :phone WHERE client_id = :id',
        [
            'name'  => $request[ 'new-client-name' ],
            'email' => $request[ 'new-client-email' ],
            'phone' => $request[ 'new-client-phone' ],
            'id'    => $id
        ]
    );

    SessionHelper::flashInit( 'success', [ 'client' => 'Client updated.' ] );
    postRedirectGet( 'admin/clients' );