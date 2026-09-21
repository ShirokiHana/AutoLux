<?php

use core\Database;

    if( !empty( $_POST ) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
        echo 'SUPER POST';
        dd( $_POST );
    }

    $data = Database::fetchAll( 'SELECT * FROM parts' );

    view( 'management/list.view.php', 'basePath', [
        'data' => $data
    ] );
