<?php

use core\CartHelper;
use core\SessionHelper;
use lib\FnArray;

screen( CartHelper::getCartState() );

require_once basePath( 'view/components/header.php' ) ?>

    <?= implode( '', SessionHelper::get( 'client' ) ) ?>

    <?php $errors = SessionHelper::getFlash( 'errors' ) ?>
    <?php $payment_class = $attr[ 'payment_method' ] ?>

    <?php view( 'components/order/cart/buildCart.php', 'basePath', [
            'cart' => $attr[ 'cart' ],
            'cartOptions' => $attr[ 'cartOptions' ],
    ] ); ?>

    <?php load( 'order/payment/renderSubtotal.php', 'renderSubtotal', [ $cart ] ); ?>

    <br>

    <form action="/order/payment" method="POST">
        <label for="">
            Payment method
            <select name="method-id" id="method-id"
                    onchange="query( { payment_method: this.selectedOptions[ 0 ].dataset.method } )">
                <?php FnArray::map( $attr[ 'payment' ], function( $element ) { ?>

                    <option value="<?= $element[ 'payment_method_id' ] ?>"
                            data-method="<?= strtoupper( $element[ 'method_name' ] ) ?>"
                            <?= strtoupper( $_GET[ 'payment_method' ] ?? '' ) === strtoupper( $element[ 'method_name' ] ) ? 'selected' : '' ?>>
                        <?= $element[ 'method_name' ] ?>
                    </option>

                <?php } ) ?>
            </select>
        </label>

        <br>

        <?= $payment_class->renderForm() ?>

        <br>

        <?php if ( isset( $errors[ 'payment' ] ) ): ?>
            <small class="error"><?= htmlspecialchars( $errors[ 'payment' ] ) ?></small>
        <?php endif; ?>

        <br>

        <input type="submit" value="Order">
    </form>

    <script>

    </script>

<?php require_once basePath( 'view/components/footer.php' ) ?>