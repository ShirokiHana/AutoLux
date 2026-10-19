<?php
    use core\Database;
    use core\SessionHelper;

    $index = $request[ 'index' ];
    $limit = $request[ 'view-limit' ];

    $where = $index ? 'WHERE c.client_name LIKE :index' : '';
    $params = $index ? [ 'index' => $index . '%' ] : [];

    $total = Database::fetch( 'Single', "SELECT COUNT(*) AS total FROM clients c $where", $params );

    $maxPage = max( 1, ( int ) ceil( $total[ 'total' ] / $limit ) );
    $page = min( $request[ 'page' ], $maxPage );
    $offset = ( $page - 1 ) * $limit;

    // [ $maxPage, $page, $offset ] = usePagination( $request[ 'page' ], $total[ 'total' ], $limit );

    $clients = Database::fetch( 'All',
        "SELECT c.client_id, c.client_name, c.email, c.phone, COUNT( o.order_id ) AS orders
             FROM clients c
             LEFT JOIN orders o ON o.client_id = c.client_id
             $where
             GROUP BY c.client_id, c.client_name, c.email, c.phone
             ORDER BY c.client_name
             LIMIT $limit OFFSET $offset", $params );

    view( 'administration/clients/list.view.php', 'basePath', [
        'clients' => $clients,
        'letters' => str_split( 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' ),
        'page' => $page,
        'maxPage' => $maxPage,
        'uri' => $uri,
        'limit' => $limit,
        'errors' => SessionHelper::getFlash( 'errors' ),
        'success' => SessionHelper::getFlash( 'success' ),
    ] );