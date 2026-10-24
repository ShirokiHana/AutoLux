<?php

use core\Database;
use core\NodeClient;
use core\RestockHelper;
use core\SessionHelper;
use lib\FnArray;

    $supplierId = ( int )( $request[ 'supplier_id' ] ?? 0 );
    // $options = [ 'part_id', 'part_type', 'part_name' ];

    $errors = SessionHelper::getFlash( 'errors' ) ?? [];

    // $page = max( 1, ( int )( $request[ 'page' ] ?? 1 ) );
    // $limit = max( 1, ( int )( $request[ 'view-limit' ] ?? 12 ) );

    $supplierParts = NodeClient::request('GET', '/supplier/' . $supplierId . '/parts');
    if ( $supplierParts === null )
        throw new Exception( 'Unable to load supplier parts', 502 );

    // ----------------Pagination
    // $total = count( $supplierParts );
    // $maxPage = max(1, ceil( $total / $limit ) );
    // $page = min( $page, $maxPage );
    // $offset = ( $page - 1 ) * $limit;

    // $parts = array_slice( $supplierParts, $offset, $limit );

    $partIds = FnArray::map(
            $supplierParts,
            function ( array $part ) : int {
                $partId = ( int )( $part[ 'part_id' ] ?? 0 );

                return $partId > 0
                    ? $partId
                    : throw new Exception( 'Invalid supplier part response', 502 );
            }
        )
            |> array_unique( ... )
            |> array_values( ... );

    $placeholders = $partIds
            |> count( ... )
            |> ( fn( int $count ) => array_fill( 0, $count, '?' ) )
            |> ( fn( array $values ) => implode( ', ', $values ) );

    $parts = $partIds === []
        ? []
        : Database::fetchAll(
            "SELECT part_id, part_type, part_name FROM parts
             WHERE part_id IN ($placeholders)
             ORDER BY part_type, part_name, part_id",
            $partIds
        );

    view('management/cart.view.php', 'basePath', [
        'supplierId' => $supplierId,
        'parts' => $parts,
        'cart' => RestockHelper::getCartState(),
        'cartOptions' => RestockHelper::getDefaultRenderingOptions(),
        'errors' => SessionHelper::getFlash( 'errors' ) ?? [],
    ]);