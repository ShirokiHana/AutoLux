<?php use lib\FnArray;

require_once basePath( 'view/components/header.php' ) ?>

    <h1>Restock Suppliers</h1>

        <?php if( !empty( $errors ) ) { ?>
            <ul>
                <?php FnArray::map( $errors, function( $error ) { ?>
                    <li><?= htmlspecialchars( ( string ) $error ) ?></li>
                <?php } ) ?>
            </ul>
        <?php } ?>

    <?php load( 'management/sqlPaginator.php', 'sqlPaginator', [ $attr[ 'page' ], $attr[ 'maxPage' ], $attr[ 'uri' ], $attr[ 'limit' ] ] ); ?>

        <?php if( !empty( $suppliers ) ) { ?>
            <form action="/management/order" method="POST">
                <label for="supplier_id">Select supplier</label>
                <select name="supplier_id" id="supplier_id">
                    <?php FnArray::map( $suppliers, function( $supplier ) { ?>
                        <option value="<?= ( int ) $supplier[ 'supplier_id' ] ?>">
                            <?= htmlspecialchars( $supplier[ 'supplier_name' ] ) ?>
                        </option>
                    <?php } ) ?>
                </select>
                <input type="submit" value="Select this supplier">
            </form>
        <?php } else { ?>
            <p>No suppliers found.</p>
        <?php } ?>


<?php require_once basePath( 'view/components/footer.php' ) ?>