<?php require_once basePath( 'view/components/header.php' ); use lib\FnArray; ?>

    <h1>Clients</h1>

    <?php if ( !empty( $errors[ 'client' ] ) ): ?>
        <p class="error"><?= htmlspecialchars( $errors[ 'client' ] ) ?></p>
    <?php endif; ?>

    <?php if ( !empty( $success ) ): ?>
        <p class="success"><?= htmlspecialchars( is_array( $success ) ? ( $success[ 'client' ] ?? '' ) : $success ) ?></p>
    <?php endif; ?>

    <?php FnArray::map( [ 'index', 'page' ], function( $key ) use ( $errors ) { ?>
        <?php if ( !empty( $errors[ $key ] ) ) { ?>
            <p class="error"><?= htmlspecialchars( $errors[ $key ] ) ?></p>
        <?php } ?>
    <?php } ) ?>

    <ul style="display: flex; list-style-type: none">
        <li style="margin-inline: .25em"><a href="/admin/clients<?= htmlspecialchars( buildQuery( [ 'index' => '' ] ) ) ?>">All</a></li>
        <?php FnArray::map( $letters, function( $element ) { ?>
            <li style="margin-inline: .25em">
                <a href="/admin/clients<?= htmlspecialchars( buildQuery( [ 'index' => strtolower( $element ) ] ) ) ?>"><?= $element ?></a>
            </li>
        <?php } ) ?>
    </ul>

    <?php load( 'management/sqlPaginator.php', 'sqlPaginator', [ $page, $maxPage, $uri, $limit ] ); ?>

    <table style="border: 1px solid">
        <tr>
            <th>Name</th>
            <th>E-mail</th>
            <th>Phone</th>
            <th>Orders</th>
            <th></th>
        </tr>
        <?php FnArray::map( $clients, function( $element ) { ?>
            <tr>
                <td><?= htmlspecialchars( $element[ 'client_name' ] ) ?></td>
                <td><?= htmlspecialchars( $element[ 'email' ] ) ?></td>
                <td><?= htmlspecialchars( $element[ 'phone' ] ) ?></td>
                <td><?= $element[ 'orders' ] ?></td>
                <td>
                    <a href="/admin/clients/<?= $element[ 'client_id' ] ?>">Edit</a>
                    <form action="/admin/clients/<?= $element[ 'client_id' ] ?>" method="POST" style="display: inline">
                        <input type="hidden" name="__method" value="DELETE">
                        <button type="submit" <?= $element[ 'orders' ] > 0 ? 'disabled title="Has orders"' : '' ?>>Delete</button>
                    </form>
                </td>
            </tr>
        <?php } ) ?>
        <?php if ( !$clients ) { ?>
            <tr><td colspan="5">No clients found.</td></tr>
        <?php } ?>
    </table>

<?php require_once basePath( 'view/components/footer.php' ) ?>