<?php

    use core\Database;

    $data = Database::fetchAll( 'SELECT * FROM parts' );

    view( 'management/list.view.php', 'basePath', [
        'data' => $data
    ] );