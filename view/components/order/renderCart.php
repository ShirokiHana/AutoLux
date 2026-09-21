<?php

use lib\FnArray;

function renderCart( array $hydratedState, array $columns ) : void {
        FnArray::map( $hydratedState, function( $part ) use ( $columns ) { ?>
                <tr>
                    <?php FnArray::map( $columns, function( $column ) use ( $part ) { ?>
                        <td style="border: 1px solid;"><?= $part[ $column ] ?></td>
                    <?php } ); ?>
                </tr>
        <?php } );
    }
?>
<script>

</script>
