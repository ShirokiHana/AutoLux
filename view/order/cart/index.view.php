<?php use lib\FnArray;

require_once basePath( 'view/components/header.php' ) ?>

        <?php view( 'components/order/add/addToCart.php', 'basePath', [
            'data' => $attr[ 'parts' ],
            'options' => $attr[ 'options' ]
        ] ); ?>

        <?php view( 'components/order/cart/buildCart.php', 'basePath', [
            'cart' => $attr[ 'cart' ],
            'cartOptions' => $attr[ 'cartOptions' ],
        ] ); ?>

<?php require_once basePath( 'view/components/footer.php' ) ?>