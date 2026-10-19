<?php

require_once basePath( 'view/components/header.php' ) ?>

        <?php view( 'components/order/add/addToCart.php', 'basePath', [
            'data' => $attr[ 'parts' ],
        ] ); ?>

        <form action="/order/cart" method="POST">
            <label for="">
                <input type="submit" value="Clear shopping cart">
            </label>
            <input type="hidden" name="__method" value="DELETE">
        </form>

        <?php view( 'components/order/cart/buildCart.php', 'basePath', [
            'cart' => $attr[ 'cart' ],
            'cartOptions' => $attr[ 'cartOptions' ],
            'extraOptions' => function( array $part ) { ?>
                <form action="/order/cart/items/<?= htmlspecialchars( (string) $part[ 'part_id' ] ) ?>" method="POST">
                    <input type="hidden" name="__method" value="DELETE">
                    <input type="hidden" name="part_id" value="<?= htmlspecialchars( ( string ) $part[ 'part_id' ] ) ?>">
                    <button type="submit">Remove</button>
                </form>
            <?php },
        ] ); ?>

        <?php load( 'order/payment/renderSubtotal.php', 'renderSubtotal', [ $cart ] ); ?>

        <a href="/order/payment">Payment</a>

<?php require_once basePath( 'view/components/footer.php' ) ?>