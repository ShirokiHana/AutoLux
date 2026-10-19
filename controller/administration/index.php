<?php

use core\Database;
use core\SessionHelper;

    $alphabet = str_split( 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' );
    $index = $request[ 'index' ];
    $clientId = $request[ 'client-id' ];
    $from = $request[ 'date-from' ];
    $to = $request[ 'date-to' ];
    $limit = $request[ 'view-limit' ];

    // Search with letter or all
    $clients = $index
        ? Database::fetch( 'All', 'SELECT client_id, client_name FROM clients WHERE client_name LIKE :index ORDER BY client_name', [ 'index' => $index . '%' ] )
        : Database::fetch( 'All', 'SELECT client_id, client_name FROM clients ORDER BY client_name' );

    $conditions = array_filter( [
        'client_id' => $clientId ? 'o.client_id = :client_id' : null,
        'from' => $from ? 'DATE(o.created_at) >= :from' : null,
        'to' => $to ? 'DATE(o.created_at) <= :to' : null,
    ] );
    $params = array_filter( [ 'client_id' => $clientId, 'from' => $from, 'to' => $to ] );
    $queryWhere = $conditions ? 'WHERE ' . implode( ' AND ', $conditions ) : '';

    //--------Pagination
    $total = Database::fetch( 'Single', "SELECT COUNT(*) AS total FROM orders o $queryWhere", $params );

    $maxPage = max( 1, ( int ) ceil( $total[ 'total' ] / $limit ) );
    $page = min( $request[ 'page' ], $maxPage );
    $offset = ( $page - 1 ) * $limit;

    // [ $maxPage, $page, $offset ] = usePagination( $request[ 'page' ], $total[ 'total' ], $limit );

    $orders = Database::fetch( 'All',
        "SELECT o.order_id, o.created_at, c.client_name, p.method_name,
                    COALESCE( SUM( i.quantity * i.unit_price ), 0 ) AS total
             FROM orders o
             JOIN clients c ON c.client_id = o.client_id
             JOIN payment_methods p ON p.payment_method_id = o.payment_method_id
             LEFT JOIN order_items i ON i.order_id = o.order_id
             $queryWhere
             GROUP BY o.order_id, o.created_at, c.client_name, p.method_name
             ORDER BY o.created_at DESC, o.order_id DESC
             LIMIT $limit OFFSET $offset", $params );

    view( 'administration/index.view.php', 'basePath', [
        'orders' => $orders,
        'clients' => $clients,
        'letters' => $alphabet,
        'clientId' => $clientId,
        'from' => $from,
        'to' => $to,
        'page' => $page,
        'maxPage' => $maxPage,
        'uri' => $uri,
        'limit' => $limit,
        'errors' => SessionHelper::getFlash( 'errors' ),
        'old' => SessionHelper::getFlash( 'old' ),
    ] );