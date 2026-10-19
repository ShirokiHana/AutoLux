<?php

    $html = loadNodeHTML( '/restock/' );

    view( 'management/select.view.php', 'basePath', [
        'html' => $html,
        'errors' => []
    ] );