<?php

    use core\NodeClient;
    use core\SessionHelper;

    NodeClient::request( 'POST', '/supplier/', [
        'supplier_name' => $request[ 'supplier_name' ],
    ] );

    SessionHelper::flashInit( 'success', [ 'supplier' => 'Supplier added.' ] );
    postRedirectGet( 'admin/suppliers' );