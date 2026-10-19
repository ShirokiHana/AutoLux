<?php

use core\SessionHelper;

    $html = loadNodeHTML( "/restock/{$request[ 'supplier_id' ]}/cart" );

    view( 'management/select.view.php', 'basePath', [
        'html' => $html,
        'errors' => SessionHelper::getFlash( 'errors' )
    ] );