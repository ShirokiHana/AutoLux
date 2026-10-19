<?php

use lib\FnArray;

function renderCart( array $hydratedState, array $columns, ?Closure $extraOptions = null ) : void {
        FnArray::map( $hydratedState, function( $part ) use ( $columns, $extraOptions ) { ?>
                <tr>
                    <?php FnArray::map( $columns, function( $column ) use ( $part ) { ?>
                        <td style="border: 1px solid; padding: .125em"><?= $part[ $column ] ?></td>
                    <?php } ); ?>
                    <?php if ( $extraOptions ) { ?>
                        <td style="border: 1px solid; padding: .125em"><?php $extraOptions( $part ) ?></td>
                    <?php } ?>
                </tr>
        <?php } );
    }
?>
<script>

</script>
