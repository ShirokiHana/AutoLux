<?php use lib\FnArray;

require_once basePath( 'view/components/header.php' ) ?>

    <h1>Suppliers</h1>

    <?php if ( !empty( $success[ 'supplier' ] ) ) { ?>
        <p><?= htmlspecialchars( $success[ 'supplier' ] ) ?></p>
    <?php } ?>


    <form action="/admin/suppliers" method="POST">
        <label>
            Supplier name
            <input
                type="text"
                name="supplier_name"
                value="<?= htmlspecialchars( $old[ 'supplier_name' ] ?? '' ) ?>"
                required
            >
        </label>
        <?php if ( !empty( $errors[ 'supplier_name' ] ) ) { ?>
            <small class="error"><?= htmlspecialchars( $errors[ 'supplier_name' ] ) ?></small>
        <?php } ?>
        <button type="submit">Add supplier</button>
    </form>

    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
        </tr>

        <?php FnArray::map( $suppliers, function ( $supplier ) { ?>
            <tr>
                <td><?= (int) $supplier[ 'supplier_id' ] ?></td>
                <td><?= htmlspecialchars( $supplier[ 'supplier_name' ] ) ?></td>
            </tr>
        <?php } ) ?>

        <?php if ( !$suppliers ) { ?>
            <tr><td colspan="2">No suppliers found.</td></tr>
        <?php } ?>
    </table>

<?php require_once basePath( 'view/components/footer.php' ) ?>