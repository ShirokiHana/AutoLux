<?php
    use core\Database;
    use core\SessionHelper;

    $id = $request[ 'id' ];

    $client = Database::fetch( 'Single', 'SELECT client_id FROM clients WHERE client_id = :id', [ 'id' => $id ] );

    if ( !$client )
        throw new Exception( 'Client not found', 404 );

    $count = Database::fetch( 'Single', 'SELECT COUNT(*) AS total FROM orders WHERE client_id = :id', [ 'id' => $id ] )[ 'total' ];

    if ( $count > 0 ) {
        SessionHelper::flashInit( 'errors', [ 'client' => "Client has {$count} order(s) and cannot be deleted." ] );
        postRedirectGet( 'admin/clients' );
    }

    Database::pushData( 'DELETE FROM clients WHERE client_id = :id', [ 'id' => $id ] );

    SessionHelper::flashInit( 'success', [ 'client' => 'Client deleted.' ] );
    postRedirectGet( 'admin/clients' );