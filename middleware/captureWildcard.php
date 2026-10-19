<?php
    namespace middleware;

    function captureAdminId( array $request ) : array {

        $path = rtrim( parse_url( $_SERVER[ 'REQUEST_URI' ] )[ 'path' ], '/' );
        $uri = $path === '' ? '/' : $path;

        if ( preg_match( '#^/admin/orders/(\d+)$#', $uri, $matches ) ) {
            return [
                ...$request,
                $matches[ 0 ]
            ];
        }
        return $request;
    }