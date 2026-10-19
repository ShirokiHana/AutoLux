<?php
    namespace middleware;

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

