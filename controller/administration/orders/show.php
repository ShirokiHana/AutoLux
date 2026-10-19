<?php

use core\Database;

    $order = Database::fetch( 'Single',
        'SELECT o.order_id, o.created_at, c.client_name, c.email, c.phone, p.method_name
             FROM orders o
             JOIN clients c ON c.client_id = o.client_id
             JOIN payment_methods p ON p.payment_method_id = o.payment_method_id
             WHERE o.order_id = :id', [ 'id' => $request[ 'id' ] ] );

        $order ?? throw new Exception( 'Order not found', 404 );

    $items = Database::fetch( 'All',
        'SELECT i.order_item_id, pt.part_name, pt.brand, i.quantity, i.unit_price,
                    i.quantity * i.unit_price AS line_total, i.installation_done
             FROM order_items i
             JOIN parts pt ON pt.part_id = i.part_id
             WHERE i.order_id = :id
             ORDER BY i.order_item_id', [ 'id' => $request[ 'id' ] ] );

    view( 'administration/orders/show.view.php', 'basePath', [
        'order' => $order,
        'items' => $items,
        'total' => array_sum( array_column( $items, 'line_total' ) ),
    ] );