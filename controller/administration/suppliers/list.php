<?php

    use core\NodeClient;
    use core\SessionHelper;

    $limit = $request[ 'view-limit' ];

    $suppliers = NodeClient::request( 'GET', '/supplier/' ) ?? [];

    $maxPage = max( 1, ( int ) ceil( count( $suppliers ) / $limit ) );
    $page = min( $request[ 'page' ], $maxPage );
    $offset = ( $page - 1 ) * $limit;

    view( 'administration/suppliers/list.view.php', 'basePath', [
        'suppliers' => array_slice( $suppliers, $offset, $limit ),
        'page' => $page,
        'maxPage' => $maxPage,
        'uri' => $uri,
        'limit' => $limit,
        'errors' => SessionHelper::getFlash( 'errors' ),
        'old' => SessionHelper::getFlash( 'old' ),
        'success' => SessionHelper::getFlash( 'success' ),
    ] );