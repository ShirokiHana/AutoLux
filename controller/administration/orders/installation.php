<?php /** @noinspection ALL */

use core\Database;

    $done = $request[ 'installation-done' ] ?? null;
    in_array( $done, [ '0', '1' ], true ) || throw new Exception( 'Invalid installation status', 400 );

    // rowCount is 0 when the value is unchanged
    $item = Database::fetch( 'Single',
        'SELECT order_item_id FROM order_items WHERE order_item_id = :item AND order_id = :id',
        [ 'item' => $request[ 'item' ], 'id' => $request[ 'id' ] ] );

        $item ?? throw new Exception( 'Order item not found', 404 );

    Database::pushData(
        'UPDATE order_items SET installation_done = :done WHERE order_item_id = :item',
        [ 'done' => ( int ) $done, 'item' => $request[ 'item' ] ] );

    postRedirectGet( 'admin/orders/' . $request[ 'id' ] );