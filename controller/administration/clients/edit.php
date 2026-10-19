<?php

    use core\Database;
    use core\SessionHelper;

    $client = Database::fetch( 'Single',
        'SELECT client_id, client_name, email, phone FROM clients WHERE client_id = :id',
        [ 'id' => $request[ 'id' ] ] );

    $client ?? throw new Exception( 'Client not found', 404 );

    view( 'administration/clients/edit.view.php', 'basePath', [
        'client' => $client,
        'errors' => SessionHelper::getFlash( 'errors' ),
        'old' => SessionHelper::getFlash( 'old' ),
    ] );