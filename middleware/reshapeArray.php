<?php
    namespace middleware;

    use JetBrains\PhpStorm\NoReturn;
    use lib\FnArray;

    function removeMethod( array $request ) : array {
        return FnArray::removeKey( $request, '__method' );
    }

    #[NoReturn]
    function dumpRequest( array $request ) : array {
        screen( $request );
        exit();
    }

    function viewRequest( array $request ) : array {
        screen( $request );
        return $request;
    }