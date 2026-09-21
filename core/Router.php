<?php

namespace core;

use Exception;
use JetBrains\PhpStorm\NoReturn;
use lib\FnArray;

// TODO: Implement Post-Redirect-Get.
class Router {
    private static array $ROUTES = [
        [ 'GET',
            [ 'uri' => '/', 'controller' => 'controller/index.php' ],
            [ 'uri' => '/status', 'controller' => 'controller/status/exception.php' ],
            [ 'uri' => '/inventory', 'controller' => 'controller/management/index.php' ],
            // TODO: Implement shopping cart GET.
            [ 'uri' => '/order', 'controller' => 'controller/order/index.php' ],
        ],

        [ 'POST',
            [ 'uri' => '/inventory', 'controller' => 'controller/management/index.php' ],
            // TODO: Hydrate $_SESSION cart with useState fn.
            [ 'uri' => '/order', 'controller' => 'controller/order/index.php' ],
        ],

        [ 'DELETE',
            [ 'uri' => '', 'controller' => '' ],
        ],

        [ 'PATCH',
            [ 'uri' => '', 'controller' => '' ],
        ],

        [ 'PUT',
            [ 'uri' => '', 'controller' => '' ],
        ],
    ];

    // TODO: Fix assoc array to array conversion
    /* @throws Exception */
    #[NoReturn]
    public static function route($method, $uri ) : string {
        $controller = FnArray::filter( self::$ROUTES, fn( $array ) => $array[ 0 ] === $method ) // Select correct method array
                |> ( fn( $array ) => FnArray::flat( $array, 1 ) ) // Flatten once
                |> ( fn( $array ) => FnArray::slice( $array, 1 ) ) // Remove __method string
                |> ( fn( $array ) => FnArray::filter( $array, fn( $route ) => $route[ 'uri' ] === $uri ) ) // Navigate to correct controller
                |> ( fn( $array ) => FnArray::flatMap( $array, fn( $element ) => $element ) ); // FlatMap
        // Return controller

        // TODO: Some( controller ) | None

        // Exception bubbles up to public/index
        return !empty( $controller[ 1 ] ) ? require_once basePath( $controller[ 1 ] ) : throw new Exception( 'Route not found!', 404 );
    }

    public static function middleware() {

    }
}