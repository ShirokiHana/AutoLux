<?php
    namespace middleware;

    use JetBrains\PhpStorm\NoReturn;
    use lib\FnArray;

    #[NoReturn]
    function updateSessionCart( array $request ) : void {
        $_SESSION[ 'cart' ] = FnArray::mergeAll( $_SESSION[ 'cart' ] ?? [], $request );
        postRedirectGet( 'inventory' );
    }