<?php use lib\FnArray;

 // TODO: background color li green for all parts installed, red for not finished orders

    $errors = fn( string $key ) : string => isset( $errors[ $key ] )
        ? '<small class="error">' . htmlspecialchars( $errors[ $key ] ) . '</small>'
        : '';

require_once basePath( 'view/components/header.php' ) ?>

    <h1>Sales registered</h1>

    <ul style="display: flex; list-style-type: none">
        <li style="margin-inline: .25em"><a href="/admin<?= htmlspecialchars( buildQuery( [ 'index' => '' ] ) ) ?>">All</a></li>
        <?php foreach ( $letters as $letter ) { ?>
            <li style="margin-inline: .25em">
                <a href="/admin<?= htmlspecialchars( buildQuery( [ 'index' => strtolower( $letter ) ] ) ) ?>"><?= $letter ?></a>
            </li>
        <?php } ?>
    </ul>

    <div>
        <label>Client
            <select data-param="client-id">
                <option value="">All clients</option>
                <?php foreach ( $clients as $client ) { ?>
                    <option value="<?= $client[ 'client_id' ] ?>" <?= ( int ) $client[ 'client_id' ] === $clientId ? 'selected' : '' ?>>
                        <?= htmlspecialchars( $client[ 'client_name' ] ) ?>
                    </option>
                <?php } ?>
            </select>
        </label>
        <?= $errors( 'client-id' ) ?>
        <label>From <input type="date" data-param="date-from" value="<?= htmlspecialchars( $from ?? '' ) ?>"></label>
        <?= $errors( 'date-from' ) ?>
        <label>To <input type="date" data-param="date-to" value="<?= htmlspecialchars( $to ?? '' ) ?>"></label>
        <?= $errors( 'date-to' ) ?>
        <?= $errors( 'page' ) ?>
        <a href="/admin">Clear</a>
    </div>

<?php load( 'management/sqlPaginator.php', 'sqlPaginator', [ $page, $maxPage, $uri, $limit ] ); ?>

    <table style="border: 1px solid">
        <tr>
            <th>Order</th><th>Client</th><th>Payment</th><th>Date</th><th>Total</th>
        </tr>
        <?php FnArray::map( $orders, function( $element ) { ?>
            <tr>
                <td><a href="/admin/orders/<?= $element[ 'order_id' ] ?>">#<?= $element[ 'order_id' ] ?></a></td>
                <td><?= htmlspecialchars( $element[ 'client_name' ] ) ?></td>
                <td><?= htmlspecialchars( $element[ 'method_name' ] ) ?></td>
                <td><?= $element[ 'created_at' ] ?></td>
                <td><?= number_format( $element[ 'total' ], 2 ) ?>€</td>
            </tr>
        <?php } ) ?>
        <?php if ( !$orders ) { ?>
            <tr><td colspan="5">No orders found.</td></tr>
        <?php } ?>
    </table>

<?php require_once basePath( 'view/components/footer.php' ) ?>