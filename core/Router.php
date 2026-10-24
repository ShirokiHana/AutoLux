<?php

namespace core;
require_once basePath( 'middleware/enforceRequire.php' );
require_once basePath( 'middleware/updateSession.php' );
require_once basePath( 'middleware/reshapeArray.php' );
require_once basePath( 'middleware/validateRequest.php' );
require_once basePath( 'middleware/captureWildcard.php' );

use Exception;
use JetBrains\PhpStorm\NoReturn;
use lib\FnArray;
// Enforce
use function middleware\cartRequireQuantity;
use function middleware\clientRequired;
use function middleware\filledCartRequired;
use function middleware\filledRestockRequired;
use function middleware\matchRestockSupplier;
use function middleware\paymentRequired;
use function middleware\receiptRequired;
// Session
use function middleware\restockClientRequired;
use function middleware\restockReceiptRequired;
use function middleware\restockRequireQuantity;
use function middleware\sanitizeClientEdit;
use function middleware\sanitizeClientFilter;
use function middleware\sanitizeOrderFilter;
use function middleware\sanitizePayment;
use function middleware\sanitizeRestock;
use function middleware\sanitizeSearch;
use function middleware\sanitizeSupplier;
use function middleware\supplierRequired;
use function middleware\updateSessionClient;
use function middleware\viewRequest;
use function middleware\wipeRestockCart;
use function middleware\wipeSessionClient;
use function middleware\wipeSessionCart;
// Reshape
use function middleware\removeMethod;
use function middleware\dumpRequest;
// Validate
use function middleware\sanitizeClient;

class Router {
    // Signature => [ 'uri' => string, 'controller' => string, 'middleware' => array? [ callable fn ] ]
    private static array $ROUTES = [
        [ 'GET',
            [ 'uri' => '/', 'controller' => 'index.php' ], // R1

            [ 'uri' => '/admin', 'controller' => 'administration/index.php', 'middleware' => [
                viewRequest( ... ),
                sanitizeOrderFilter( ... ),
            ] ], // R1

            [ 'uri' => '/admin/orders/{id}', 'controller' => 'administration/orders/show.php', 'middleware' => [

            ] ], // R1

            [ 'uri' => '/admin/clients', 'controller' => 'administration/clients/list.php', 'middleware' => [
                viewRequest( ... ),
                sanitizeClientFilter( ... )
            ] ],
            [ 'uri' => '/admin/clients/{id}', 'controller' => 'administration/clients/edit.php' ],

            [ 'uri' => '/admin/suppliers', 'controller' => 'administration/suppliers/list.php' ],

            [ 'uri' => '/status', 'controller' => 'status/exception.php' ], // R2
            [ 'uri' => '/inventory', 'controller' => 'management/index.php', 'middleware' => [ sanitizeSearch( ... ), ] ], // R3
            [ 'uri' => '/logout', 'controller' => '.php' ], // R4
            // load node app
            [ 'uri' => '/management/order', 'controller' => 'management/select.php', 'middleware' => [  ] ], // R5

            [ 'uri' => '/management/order/cart', 'controller' => 'management/cart/cart.php', 'middleware' => [
                matchRestockSupplier( ... ),
                supplierRequired( ... ),
            ] ], //
            [ 'uri' => '/management/order/confirmation', 'controller' => 'management/cart/confirmation.php', 'middleware' => [
                restockReceiptRequired( ... ),
            ] ], //
            // Render client list -> new client || cart
            [ 'uri' => '/order', 'controller' => 'order/index.php', 'middleware' => [  ] ], // R6
            // new client
            [ 'uri' => '/order/new', 'controller' => 'order/client/create.php', 'middleware' => [ wipeSessionClient( ... ), ] ], // R7
            // render cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/index.php', 'middleware' => [ clientRequired( ... ), ] ], // R8
            // render payment form
            [ 'uri' => '/order/payment', 'controller' => 'order/payment/index.php', 'middleware' => [
                viewRequest( ... ),
                filledCartRequired( ... ),
                clientRequired( ... ),
            ] ], // R9
            [ 'uri' => '/order/confirmation', 'controller' => 'order/payment/list.php', 'middleware' => [
                wipeSessionClient( ... ),
                wipeSessionCart( ... ),
                receiptRequired( ... ),
            ] ], // R10
        ],

        [ 'POST',
            // add user to db, PRG to PUT
            [ 'uri' => '/order/new', 'controller' => 'order/client/store.php', 'middleware' => [
                // dumpRequest( ... ),
                sanitizeClient( ... ),
            ] ], // R11
            // POST redirects to /order/cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/index.php', 'middleware' => [
                viewRequest( ... ),
                clientRequired( ... ),
                updateSessionClient( ... ),
                wipeSessionCart( ... ),
            ] ], // R12
            // post writes order to db, PRG to confirm order page
            [ 'uri' => '/order/payment', 'controller' => 'order/payment/store.php', 'middleware' => [
                // dumpRequest( ... ),
                sanitizePayment( ... ),
                paymentRequired( ... ),
                filledCartRequired( ... ),
                clientRequired( ... ),
            ] ], // R13
            [ 'uri' => '/management/order', 'controller' => 'management/supplier.php', 'middleware' => [
                supplierRequired( ... ),
            ] ], // R14
            [ 'uri' => '/management/order/cart', 'controller' => 'management/cart/restock.php', 'middleware' => [
                sanitizeRestock( ... ),
                matchRestockSupplier( ... ),
                supplierRequired( ... ),
            ] ], // R15
            [ 'uri' => '/login', 'controller' => 'session/store.php', 'middleware' => [

            ] ], // R16

            [ 'uri' => '/admin/suppliers', 'controller' => 'administration/suppliers/store.php', 'middleware' => [
                sanitizeSupplier( ... ),
            ] ],

        ],

        [ 'DELETE',
            // TODO: Logout/destroy session.
            [ 'uri' => '/logout', 'controller' => 'session/destroy.php', 'middleware' => [

            ] ], // R
            // clear sess cart, prg to render cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/destroy.php', 'middleware' => [
                wipeSessionCart( ... ),
                filledCartRequired( ... ),
                clientRequired( ... ),
            ] ], // R15

            [ 'uri' => '/management/order/cart', 'controller' => 'management/cart/destroy.php', 'middleware' => [
                wipeRestockCart( ... ),
                // filledRestockRequired( ... ),
                // restockClientRequired( ... ),
            ] ], // R15

            [ 'uri' => '/management/order/cart/{id}', 'controller' => 'management/cart/remove.php', 'middleware' => [
                filledRestockRequired( ... ),
                restockClientRequired( ... ),
            ] ], // R15

            [ 'uri' => '/admin/clients/{id}', 'controller' => 'administration/clients/destroy.php' ],

            [ 'uri' => '/order/cart/items/{part_id}', 'controller' => 'order/cart/remove.php', 'middleware' => [
                filledCartRequired( ... ),
                clientRequired( ... ),
            ] ],
        ],

        [ 'PATCH',
            [ 'uri' => '', 'controller' => '' ],
            [ 'uri' => '/admin/orders/{id}/items/{item}', 'controller' => 'administration/orders/installation.php' ], // R16
            [ 'uri' => '/admin/clients/{id}', 'controller' => 'administration/clients/update.php', 'middleware' => [
                sanitizeClientEdit( ... ),
            ] ],
        ],

        [ 'PUT',
            // middleware add/delete session cart, prg to render cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/replace.php', 'middleware' => [
                cartRequireQuantity( ... ),
                removeMethod( ... ),
                clientRequired( ... ),
            ] ], // R17

            [ 'uri' => '/management/order/cart', 'controller' => 'management/cart/replace.php', 'middleware' => [
                matchRestockSupplier( ... ),
                restockRequireQuantity( ... ),
                removeMethod( ... ),
                restockClientRequired( ... ),
            ] ], // R17
            // middleware writes client id to sess, PRG to /order/cart
            // [ 'uri' => 'client/new', 'controller' => 'client/select.php', 'middleware' => [  ] ],
        ],
    ];

    // TODO: Fix assoc array to array conversion
    /* @throws Exception */
    #[NoReturn]
    public static function route( string $method, string $uri, array $request ) : string {

        // --------------PUT IN MIDDLEWARE TODO: captureWildcard -> match from pattern array
        if ( preg_match( '#^/admin/orders/(\d+)$#', $uri, $matches ) ) {
            $request[ 'id' ] = ( int ) $matches[ 1 ];
            $uri = '/admin/orders/{id}';
        } elseif ( preg_match( '#^/admin/orders/(\d+)/items/(\d+)$#', $uri, $matches ) ) {
            $request[ 'id' ] = ( int ) $matches[ 1 ];
            $request[ 'item' ] = ( int ) $matches[ 2 ];
            $uri = '/admin/orders/{id}/items/{item}';
        } elseif ( preg_match( '#^/admin/clients/(\d+)$#', $uri, $matches ) ) {
            $request[ 'id' ] = ( int ) $matches[ 1 ];
            $uri = '/admin/clients/{id}';
        } elseif ( preg_match( '#^/order/cart/items/(\d+)$#', $uri, $matches ) ) {
            $request[ 'part_id' ] = ( int ) $matches[ 1 ];
            $uri = '/order/cart/items/{part_id}';
        }  elseif ( preg_match( '#^/management/order/cart/(\d+)$#', $uri, $matches ) ) {
            $request[ 'id' ] = ( int ) $matches[ 1 ];
            $uri = '/management/order/cart/{id}';
        }
        // --------------PUT IN MIDDLEWARE

        $controller = FnArray::filter( self::$ROUTES, fn( $array ) => $array[ 0 ] === $method ) // Select correct method array
                |> ( fn( $array ) => FnArray::flat( $array, 1 ) ) // Flatten once
                |> ( fn( $array ) => FnArray::slice( $array, 1 ) ) // Remove __method string TODO: Middleware fn to remove method
                |> ( fn( $array ) => FnArray::filter( $array, fn( $route ) => $route[ 'uri' ] === $uri ) ) // Navigate to correct controller
                |> ( fn( $array ) => FnArray::flatMap( $array, fn( $element ) => $element ) ); // FlatMap
        // Return controller

        // Run middleware
        $run = callStack( ...( $controller[ 2 ] ?? [] ) );
        $request = array( ...$run( $request ) );

        // Global middleware
        try {
            CartHelper::set( $_SESSION[ 'cart' ] ?? [] );
            RestockHelper::set( $_SESSION[ 'restockCart' ] ?? [] );
        } catch ( Exception $exception ) {
            abort( throw new Exception( "Internal Server Error: $exception" ), 500 );
        }

        // Exception bubbles up to public/index
        $output = !empty( $controller[ 1 ] )
            ? require_once basePath( 'controller/' . $controller[ 1 ] )
            : throw new Exception( 'Route not found!', 404 );

        // Global middleware
        try {
            SessionHelper::unflashSession();
        } catch ( Exception $exception ) {
            abort( throw new Exception( "Internal Server Error: $exception" ), 500 );
        }

        return $output;
    }
}

// TODO: Hydrate $_SESSION cart with useState fn. ✅
// TODO: Implement Post-Redirect-Get. ✅
// TODO: Clear cart.