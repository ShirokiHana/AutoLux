<?php

use core\Database;

    $clients = Database::fetchAll( 'SELECT client_name FROM clients' );

    view( 'order/client/index.view.php', 'basePath', [
            'clients' => $clients
        ] );