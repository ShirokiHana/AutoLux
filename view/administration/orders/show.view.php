<?php use lib\FnArray;

require_once basePath( 'view/components/header.php' ) ?>

    <h1>Order #<?= $order[ 'order_id' ] ?></h1>
    <p>Client: <?= htmlspecialchars( $order[ 'client_name' ] ) ?>
        (<?= htmlspecialchars( $order[ 'email' ] ) ?>, <?= htmlspecialchars( $order[ 'phone' ] ) ?>)</p>
    <p>Payment: <?= htmlspecialchars( $order[ 'method_name' ] ) ?></p>
    <p>Date: <?= $order[ 'created_at' ] ?></p>

    <table style="border: 1px solid">
        <tr>
            <th>Part</th>
            <th>Quantity</th>
            <th>Unit price</th>
            <th>Subtotal</th>
            <th>Installation</th>
        </tr>
        <?php FnArray::map( $items, function( $element ) use ( $order ) { ?>
            <tr>
                <td><?= htmlspecialchars( $element[ 'brand' ] . ' ' . $element[ 'part_name' ] ) ?></td>
                <td><?= $element[ 'quantity' ] ?></td>
                <td><?= number_format( $element[ 'unit_price' ], 2 ) ?>€</td>
                <td><?= number_format( $element[ 'line_total' ], 2 ) ?>€</td>
                <td>
                    <form method="POST" action="/admin/orders/<?= $order[ 'order_id' ] ?>/items/<?= $element[ 'order_item_id' ] ?>">
                        <input type="hidden" name="__method" value="PATCH">
                        <input type="hidden" name="installation-done" value="<?= $element[ 'installation_done' ] ? 0 : 1 ?>">
                        <?= $element[ 'installation_done' ] ? 'Done' : 'Pending' ?>
                        <button type="submit"><?= $element[ 'installation_done' ] ? 'Mark pending' : 'Mark installed' ?></button>
                    </form>
                </td>
            </tr>
        <?php } ) ?>
        <tr>
            <th colspan="3">Total</th>
            <th colspan="2">€<?= number_format( (float) $total, 2 ) ?></th>
        </tr>
    </table>

    <a href="/admin">← Back to orders</a>

<?php require_once basePath( 'view/components/footer.php' ) ?>