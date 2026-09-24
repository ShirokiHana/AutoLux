<?php

namespace core;
require_once basePath( 'middleware/updateSessionCart.php' );

use Closure;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use lib\FnArray;

use function middleware\updateSessionCart;

class Router {
    // Signature => [ 'uri' => string, 'controller' => string, 'middleware' => array? [ callable fn ] ]
    private static array $ROUTES = [
        [ 'GET',
            [ 'uri' => '/', 'controller' => 'index.php' ],
            [ 'uri' => '/status', 'controller' => 'status/exception.php' ],
            [ 'uri' => '/inventory', 'controller' => 'management/index.php' ],
            [ 'uri' => '/logout', 'controller' => '.php' ],
            // Render client list -> new client || cart
            [ 'uri' => '/order', 'controller' => 'order/index.php' ],
            // new client
            [ 'uri' => '/order/new', 'controller' => 'order/client/create.php' ],
            // render cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/index.php' ],
            // render payment form
            [ 'uri' => '/order/payment', 'controller' => 'order/payment/index.php' ],
        ],

        [ 'POST',
            [ 'uri' => '/inventory', 'controller' => 'management/index.php', 'middleware' => [  ]  ],
            // add user to db, PRG to PUT
            [ 'uri' => '/order/new', 'controller' => 'order/client/store.php', 'middleware' => [  ] ],
            // POST redirects to /order/payment
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/index.php', 'middleware' => [  ] ],
            // post writes order to db, PRG to confirm order page
            [ 'uri' => '/order/payment', 'controller' => 'order/index.php', 'middleware' => [  ] ],
        ],

        [ 'DELETE',
            // TODO: Logout/destroy session.
            [ 'uri' => '/logout', 'controller' => '' ],
            // clear sess cart, prg to render cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/destroy.php', 'middleware' => [  ] ],
        ],

        [ 'PATCH',
            [ 'uri' => '', 'controller' => '' ],
        ],

        [ 'PUT',
            // middleware add/delete session cart, prg to render cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/replace.php', 'middleware' => [ updateSessionCart( ... ) ] ],
            // middleware writes client id to sess, PRG to /order/cart
            [ 'uri' => 'client/new', 'controller' => 'client/replace.php', 'middleware' => [  ] ],
        ],
    ];

    // TODO: Fix assoc array to array conversion
    /* @throws Exception */
    #[NoReturn]
    public static function route( string $method, string $uri, array $request ) : string {
        $controller = FnArray::filter( self::$ROUTES, fn( $array ) => $array[ 0 ] === $method ) // Select correct method array
                |> ( fn( $array ) => FnArray::flat( $array, 1 ) ) // Flatten once
                |> ( fn( $array ) => FnArray::slice( $array, 1 ) ) // Remove __method string
                |> ( fn( $array ) => FnArray::filter( $array, fn( $route ) => $route[ 'uri' ] === $uri ) ) // Navigate to correct controller
                |> ( fn( $array ) => FnArray::flatMap( $array, fn( $element ) => $element ) ); // FlatMap
        // Return controller

        // Run middleware
        $run = self::middleware( ...( $controller[ 2 ] ?? [] ) );
        $request = array( ...$run( $request ) );

        // Exception bubbles up to public/index
        return !empty( $controller[ 1 ] ) ? require_once basePath( 'controller/' . $controller[ 1 ] ) : throw new Exception( 'Route not found!', 404 );
    }

    public static function middleware( callable ...$fns ) : Closure {
        return function ( mixed $x ) use ( $fns ) : mixed {
            foreach ( array_reverse( $fns ) as $fn ) {
                $x = $fn( $x );
            }
            return $x;
        };
    }
}

// TODO: Hydrate $_SESSION cart with useState fn. ✅
// TODO: Implement Post-Redirect-Get. ✅
// TODO: Clear cart.