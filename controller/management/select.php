<?php

    use core\NodeClient;
    use core\SessionHelper;

    $errors = SessionHelper::getFlash('errors') ?? [];

    $page = max( 1, ( int ) ( $request[ 'page' ] ?? 1 ) );
    $limit = max( 1, ( int ) ( $request[ 'view-limit' ] ?? 12 ) );

    $suppliers = NodeClient::request('GET', '/supplier') ?? [];
    if ( !is_array( $suppliers ) )
        $suppliers = [];

// ----------------Pagination
    $total = count( $suppliers );

    $maxPage = max( 1, ( int ) ceil( $total / $limit ) );
    $page = min( $page, $maxPage );
    $offset = ( $page - 1 ) * $limit;

    $currentSuppliers = array_slice( $suppliers, $offset, $limit );

    view('management/select.view.php', 'basePath', [
        'suppliers' => $currentSuppliers,
        'page' => $page,
        'maxPage' => $maxPage,
        'limit' => $limit,
        'uri' => $uri,
        'errors' => $errors,
    ]);