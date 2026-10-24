<?php

use core\SessionHelper;

    view( 'management/confirmation.view.php', 'basePath',
        [ 'receipt' => SessionHelper::getFlash( 'restock' )
    ] );