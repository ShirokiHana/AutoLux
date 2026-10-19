<?php

    use core\NodeClient;
    use core\SessionHelper;

    $suppliers = NodeClient::request( 'GET', '/supplier/' ) ?? [];

    view( 'administration/suppliers/list.view.php', 'basePath', [
        'suppliers' => $suppliers,
        'errors' => SessionHelper::getFlash( 'errors' ),
        'old' => SessionHelper::getFlash( 'old' ),
        'success' => SessionHelper::getFlash( 'success' ),
    ] );