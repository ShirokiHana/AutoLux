<?php

require_once basePath( 'view/components/header.php' ) ?>

<?php [ 'order_id' => $order_id,
        'client_name' => $client_name,
        'payment_name' => $payment_name ] = $attr[ 'receipt' ] ?>

    <p>✅</p>
    <p>Order #<?= $order_id ?> successful!</p>
    <p>Thank you <?= $client_name ?> for trusting us!</p>
    <p>The payment was charged to your <?= $payment_name ?> card</p>

<?php require_once basePath( 'view/components/footer.php' ) ?>
