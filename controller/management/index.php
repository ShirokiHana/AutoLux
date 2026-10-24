<?php

    use core\Database;
    use lib\FnArray;

    $conditions = array_filter( [
        ':search' => $request[ 'input-search' ] !== null
            ? "{$request[ 'inventory-filter' ]} = :search"
            : null,

        ':range' => $request[ 'inventory-filter-range' ] < 300
            ? 'price <= :range'
            : null, // 300 means no limit, searches all prices
    ] );

    $params = FnArray::filter( [
        'search' => $request[ 'input-search' ],
        'range' => $request[ 'inventory-filter-range' ] < 300
            ? $request[ 'inventory-filter-range' ]
            : null,
    ], fn( $value ) => $value !== null );

    $queryWhere = $conditions
        ? 'WHERE ' . implode( ' AND ', $conditions )
        : '';

// ----------------Pagination

    $total = Database::fetch( 'Single', "SELECT COUNT(*) AS total FROM parts $queryWhere", $params );

    $limit = $request[ 'view-limit' ];
    if ( $limit < 1 )
        $limit = 12;

    $maxPage = max( 1, ( int ) ceil( $total[ 'total' ] / $limit ) );
    $page = min( $request[ 'page' ], $maxPage );
    $offset = ( $page - 1 ) * $limit;

// ----------------Data Table

    $data = Database::fetch( 'All',
        "SELECT part_id, part_name, brand,part_type, stock_quantity AS quantity FROM parts
                $queryWhere
                LIMIT " . ( $limit + 1 ) . " OFFSET $offset", $params );

    view( 'management/index.view.php', 'basePath', [
        'query' => $request,
        'data' => $data,
        'page' => $page,
        'maxPage' => $maxPage,
        'uri' => $uri,
        'limit' => $limit,
        'target' => 'order/cart',
    ] );