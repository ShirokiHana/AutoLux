<?php use lib\FnArray;

require_once basePath('view/components/header.php') ?>

    <h1>Supplier order cart</h1>
    <p>Supplier #<?= ( int )$attr[ 'supplierId' ] ?></p>

    <?php if ( !empty( $attr[ 'errors' ] ) ) { ?>
        <ul>
            <?php FnArray::map( $attr[ 'errors' ], function ( $error ) { ?>
                <li><?= htmlspecialchars( $error ) ?></li>
            <?php }) ?>
        </ul>
    <?php } ?>

    <?php view( 'components/order/add/addToCart.php', 'basePath', [
            'data' => $attr[ 'parts' ],
            'target' => '/management/order/cart?' . http_build_query( [
                            'supplier_id' => $attr[ 'supplierId' ],
                    ] ),
    ] ); ?>

    <form action="/management/order/cart" method="POST">
        <label for="">
            <input type="submit" value="Clear restock cart">
        </label>
        <input type="hidden" name="__method" value="DELETE">
        <input type="hidden" name="supplier_id" value="<?= ( int ) $attr[ 'supplierId' ] ?>">
    </form>

    <?php view( 'components/order/cart/buildCart.php', 'basePath', [
            'cart' => $attr[ 'cart' ],
            'cartOptions' => $attr[ 'cartOptions' ],
            'extraOptions' => function( array $part ) use ( $attr ) { ?>
                <form action="/management/order/cart/<?= htmlspecialchars( (string) $part[ 'part_id' ] ) ?>" method="POST">
                    <input type="hidden" name="__method" value="DELETE">
                    <input type="hidden" name="supplier_id" value="<?= ( int ) $attr[ 'supplierId' ] ?>">
                    <input type="hidden" name="part_id" value="<?= htmlspecialchars( ( string ) $part[ 'part_id' ] ) ?>">
                    <button type="submit">Remove</button>
                </form>
            <?php },
    ] ); ?>

    <?php load( 'order/payment/renderSubtotal.php', 'renderSubtotal', [ $cart ] ); ?>

    <form action="/management/order/cart" method="POST">
        <input type="hidden" name="supplier_id" value="<?= ( int ) $attr[ 'supplierId' ] ?>">
        <input type="submit" value="Make restock request">
    </form>

    <?php require_once basePath('view/components/footer.php') ?>