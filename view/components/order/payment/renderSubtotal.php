<?php

use core\CartHelper;
use lib\FnArray;

function renderSubtotal( array $hydratedState ) : void {
    $id = FnArray::map( $hydratedState, fn( $array ) => $array[ 'part_id' ] );
    $priceArray = FnArray::map( $id, fn( $element) => CartHelper::fetchPartPrice( $element ) );

    $quantities = FnArray::map( $hydratedState, fn( $array ) => $array[ 'quantity' ] );

    $total = array_map( fn( $price, $quantity ) => $price * $quantity, $priceArray, $quantities );

    $subtotal = array_reduce( $total, fn($carry, $element ) => $carry + $element ); ?>
        <p>Total: <?= $subtotal ?>€</p>
<?php } ?>
<script>

</script>