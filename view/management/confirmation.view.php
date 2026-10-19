<?php

use lib\FnArray;

require_once basePath( 'view/components/header.php' ) ?>

        <p>Restock from supplier #<?= $receipt[ 'supplier_id' ] ?>.</p>
        Following parts were restocked:
        <ul>
            <?php FnArray::map( $receipt[ 'items' ], function( $element ) { ?>
                <li>#<?= $element[ 'part_id' ] ?> x<?= $element[ 'quantity' ] ?></li>
            <?php } ) ?>
        </ul>
        <a href="/inventory">Check inventory</a>

    <?php require_once basePath( 'view/components/footer.php' ) ?>