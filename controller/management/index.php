<?php

    if( isset( $_POST ) ) {
        echo 'GET POST';
        dd( $_POST );
    }

    use core\Database;

    $data = Database::fetchAll( 'SELECT * FROM parts' );

    view( 'management/list.view.php', 'basePath', [
        'data' => $data
    ] );