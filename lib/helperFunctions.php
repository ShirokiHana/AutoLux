<?php

use JetBrains\PhpStorm\NoReturn;

    function dd($var ) : void {
        print "<pre>";
        var_dump( $var );
        print "</pre>";
    }

    function view( $path, $fn = 'basePath', $attr = [] ) : void {
        extract( $attr );
        require $fn( 'view/' . $path );
    }

    // TODO: Refactor, merge with view().
    function load( $path , $fn, $options = [] ) : void {
        require_once basePath( 'view/components/' . $path );
        $fn( ...$options );
    }

    #[NoReturn]
    function abort( $exception, $errorCode = 404 ) : void {
        http_response_code( $errorCode );
        view( 'status/exception.view.php', 'basePath', [
            'exception' => $exception->getMessage(),
            'code' => $errorCode
        ] );
        exit();
    }

    function basePath( $path ) : string {
        return BASE_PATH . $path;
    }

    $mergeState = fn( array $newState = [] ) => function( array $staleState = [] ) use ( $newState ) {
        return array_merge( $staleState, $newState );
    };