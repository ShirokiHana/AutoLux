<?php

use core\Database;

    $alphabet = str_split('ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    $index = strtoupper( substr( (string) ( $request[ 'index' ] ?? '' ), 0, 1 ) );

    $clients = in_array( $index, $alphabet, true )
        ? Database::fetch( 'All', 'SELECT client_id, client_name FROM clients WHERE client_name LIKE :index ORDER BY client_name', [ 'index' => $index . '%' ] )
        : Database::fetch( 'All', 'SELECT client_id, client_name FROM clients ORDER BY client_name' );

    view( 'order/client/index.view.php', 'basePath', [
            'clients' => $clients,
            'letters' => $alphabet,
        ] );