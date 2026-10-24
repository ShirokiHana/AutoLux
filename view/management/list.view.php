<?php use lib\FnArray;

// TODO: Delete?

require_once basePath( 'view/components/header.php' ) ?>

    <?php load( 'management/form.php', 'managementForm' ); ?>

    <article>
        <table style="border: 1px solid">
            <tr>
                <th style="border: 1px solid">Part Name</th>
                <th style="border: 1px solid">Stock</th>
            </tr>
            <?php FnArray::map( $attr[ 'data' ], function ( $entry ) { ?>
                <tr>
                    <td style="border: 1px solid"><?= $entry[ 'part_name' ] ?></td>
                    <td style="border: 1px solid"><?= $entry[ 'stock_quantity' ] ?></td>
                </tr>
            <?php } ) ?>
        </table>
    </article>

<?php require_once basePath( 'view/components/footer.php' ) ?>