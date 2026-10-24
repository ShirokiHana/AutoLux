<?php
    namespace middleware;

    use core\RestockHelper;
    use core\SessionHelper;

    function updateSessionClient( array $request ) : array {
        SessionHelper::set( 'client', ( array )( $request[ 'client' ] ?? [] ) );
        return $request;
        // What????
        // postRedirectGet( 'order/cart' );
    }

    function wipeSessionClient( array $request ) : array {
        SessionHelper::set( 'client', [] );
        return $request;
    }

    function wipeSessionCart( array $request ) : array {
        $currentClient = SessionHelper::get( 'client' );
        $requestClient = $request[ 'client' ] ?? null;

        if ( $requestClient !== ( $currentClient[ 0 ] ?? null ) ) {
            SessionHelper::set( 'cart', [] );
        }
        return $request;
    }

    function wipeRestockCart( array $request ) : array {
        SessionHelper::set( 'restockCart', [] );
        return $request;
    }

    function matchRestockSupplier( array $request ) : array {
        $supplierId = ( int ) $request[ 'supplier_id' ];

        foreach ( SessionHelper::get( 'restockCart' ) as $item ) {
            if ( ( int ) ( $item[ 'supplier_id' ] ?? 0 ) !== $supplierId ) {
                wipeRestockCart( $request );

                SessionHelper::flashInit( 'errors', [
                    'supplier' => 'The restock cart was cleared because the supplier changed.',
                ] );

                postRedirectGet(
                    'management/order/cart?supplier_id=' . $supplierId
                );
            }
        }

        return $request;
    }

