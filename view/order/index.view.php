<?php use lib\FnArray;

require_once basePath( 'view/components/header.php' ) ?>

    <h1>Orders</h1>

    <form action="/order" method="POST">
        <label for="">
            <select>
                <?php FnArray::map( $attr[ 'clients' ], function( $name ) { ?>
                    <option value=""><?= $name[ 'client_name' ] ?></option>
                <?php } ) ?>
            </select>
        </label>
        <input type="submit" value="+">

        <?php view( 'components/order/add/addToCart.php', 'basePath', [
                'data' => $attr[ 'parts' ],
                'options' => $attr[ 'options' ]
        ] ); ?>

        <?php view( 'components/order/cart/buildCart.php', 'basePath', [
                'cart' => $attr[ 'cart' ],
                'cartOptions' => $attr[ 'cartOptions' ],
        ] ); ?>

        <p>Payment method</p>
        <label for="">
            <select name="" id="">
                <option value="">MBWay</option>
                <option value="">Visa</option>
                <option value="">MasterCard</option>
            </select>
        </label>

        <p>Total: 425€</p>
        <input type="submit" value="Order">
    </form>

<?php require_once basePath( 'view/components/footer.php' ) ?>