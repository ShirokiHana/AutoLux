<?php use core\CartHelper;

require_once basePath( 'view/components/header.php' ) ?>

    <?php load( 'management/form.php', 'managementForm', [ $attr[ 'query' ] ] ); ?>

    <?php load( 'management/sqlPaginator.php', 'sqlPaginator', [ $attr[ 'page' ], $attr[ 'maxPage' ], $attr[ 'uri' ], $attr[ 'limit' ] ] ); ?>

    <?php view( 'components/order/cart/buildCart.php', 'basePath', [
            'cart' => $attr[ 'data' ],
            'cartOptions' => CartHelper::getDefaultRenderingOptions(),
    ] ); ?>

<?php require_once basePath( 'view/components/footer.php' ) ?>