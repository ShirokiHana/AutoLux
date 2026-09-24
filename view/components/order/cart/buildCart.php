<?php use lib\FnArray; ?>
<h2>Shopping cart:</h2>
<table style="border: 1px solid;">
        <tr style="border: 1px solid;">
            <?php FnArray::map( $cartOptions, function( $element ) { ?>
                <th style="border: 1px solid;"><?= formatStringLabel( $element ) ?></th>
            <?php } ) ?>
        </tr>

    <?php load( 'order/cart/renderCart.php', 'renderCart', [ $cart, $cartOptions ] ); ?>
</table>

