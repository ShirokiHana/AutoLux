<?php

use core\SessionHelper;

    $receipt = SessionHelper::getFlash( 'receipt' );

    view( 'order/payment/list.view.php', 'basePath', [
        // Render receipt
        'receipt' => $receipt
    ] );