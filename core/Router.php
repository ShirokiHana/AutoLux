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
use function middleware\sanitizeSupplierFilter;
use function middleware\supplierRequired;
use function middleware\updateSessionClient;
use function middleware\wipeRestockCart;
use function middleware\wipeSessionClient;
use function middleware\wipeSessionCart;
// Reshape
use function middleware\removeMethod;
// Unused but flagged if active by IDE
use function middleware\viewRequest;
use function middleware\dumpRequest;
// Validate
use function middleware\sanitizeClient;

class Router {
    // Signature => [ 'uri' => string, 'controller' => string, 'middleware' => array? [ callable fn ] ]
    private static array $ROUTES = [
        [ 'GET',
            [ 'uri' => '/', 'controller' => 'index.php' ], // R1

            [ 'uri' => '/admin', 'controller' => 'administration/index.php', 'middleware' => [
                sanitizeOrderFilter( ... ),
            ] ], // R2

            [ 'uri' => '/admin/orders/{id}', 'controller' => 'administration/orders/show.php', 'middleware' => [

            ] ], // R3

            [ 'uri' => '/admin/clients', 'controller' => 'administration/clients/list.php', 'middleware' => [
                sanitizeClientFilter( ... )
            ] ], // R4

            [ 'uri' => '/admin/clients/{id}', 'controller' => 'administration/clients/edit.php' ], // R5

            [ 'uri' => '/admin/suppliers', 'controller' => 'administration/suppliers/list.php', 'middleware' => [
                sanitizeSupplierFilter( ... )
            ] ], // R6

            [ 'uri' => '/status', 'controller' => 'status/exception.php' ], // R7

            [ 'uri' => '/inventory', 'controller' => 'management/index.php', 'middleware' => [ sanitizeSearch( ... ), ] ], // R8

            [ 'uri' => '/logout', 'controller' => '.php' ], // R9
                // load node app
            [ 'uri' => '/management/order', 'controller' => 'management/select.php', 'middleware' => [  ] ], // R10

            [ 'uri' => '/management/order/cart', 'controller' => 'management/cart/cart.php', 'middleware' => [
                matchRestockSupplier( ... ),
                supplierRequired( ... ),
            ] ], // R11

            [ 'uri' => '/management/order/confirmation', 'controller' => 'management/cart/confirmation.php', 'middleware' => [
                restockReceiptRequired( ... ),
            ] ], // R12
                // Render client list -> new client || cart
            [ 'uri' => '/order', 'controller' => 'order/index.php', 'middleware' => [  ] ], // R13
                // new client
            [ 'uri' => '/order/new', 'controller' => 'order/client/create.php', 'middleware' => [ wipeSessionClient( ... ), ] ], // R14
                // render cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/index.php', 'middleware' => [ clientRequired( ... ), ] ], // R15
                // render payment form
            [ 'uri' => '/order/payment', 'controller' => 'order/payment/index.php', 'middleware' => [
                filledCartRequired( ... ),
                clientRequired( ... ),
            ] ], // R16

            [ 'uri' => '/order/confirmation', 'controller' => 'order/payment/list.php', 'middleware' => [
                wipeSessionClient( ... ),
                wipeSessionCart( ... ),
                receiptRequired( ... ),
            ] ], // R17
        ],

        [ 'POST',
                // add user to db, PRG to PUT
            [ 'uri' => '/order/new', 'controller' => 'order/client/store.php', 'middleware' => [
                sanitizeClient( ... ),
            ] ], // R18

                // POST redirects to /order/cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/index.php', 'middleware' => [
                clientRequired( ... ),
                updateSessionClient( ... ),
                wipeSessionCart( ... ),
            ] ], // R19
                // post writes order to db, PRG to confirm order page
            [ 'uri' => '/order/payment', 'controller' => 'order/payment/store.php', 'middleware' => [
                sanitizePayment( ... ),
                paymentRequired( ... ),
                filledCartRequired( ... ),
                clientRequired( ... ),
            ] ], // R20

            [ 'uri' => '/management/order', 'controller' => 'management/supplier.php', 'middleware' => [
                supplierRequired( ... ),
            ] ], // R21

            [ 'uri' => '/management/order/cart', 'controller' => 'management/cart/restock.php', 'middleware' => [
                sanitizeRestock( ... ),
                matchRestockSupplier( ... ),
                supplierRequired( ... ),
            ] ], // R22

            [ 'uri' => '/login', 'controller' => 'session/store.php', 'middleware' => [

            ] ], // R23

            [ 'uri' => '/admin/suppliers', 'controller' => 'administration/suppliers/store.php', 'middleware' => [
                sanitizeSupplier( ... ),
            ] ], // R24

        ],

        [ 'DELETE',
                // TODO: Logout/destroy session.
            [ 'uri' => '/logout', 'controller' => 'session/destroy.php', 'middleware' => [

            ] ], // R25
                // clear sess cart, prg to render cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/destroy.php', 'middleware' => [
                wipeSessionCart( ... ),
                filledCartRequired( ... ),
                clientRequired( ... ),
            ] ], // R26

            [ 'uri' => '/management/order/cart', 'controller' => 'management/cart/destroy.php', 'middleware' => [
                wipeRestockCart( ... ),
                filledRestockRequired( ... ),
                restockClientRequired( ... ),
            ] ], // R27

            [ 'uri' => '/management/order/cart/{id}', 'controller' => 'management/cart/remove.php', 'middleware' => [
                filledRestockRequired( ... ),
                restockClientRequired( ... ),
            ] ], // R28

            [ 'uri' => '/admin/clients/{id}', 'controller' => 'administration/clients/destroy.php' ], // R29

            [ 'uri' => '/order/cart/items/{part_id}', 'controller' => 'order/cart/remove.php', 'middleware' => [
                filledCartRequired( ... ),
                clientRequired( ... ),
            ] ], // R30
        ],

        [ 'PATCH',
            [ 'uri' => '/admin/orders/{id}/items/{item}', 'controller' => 'administration/orders/installation.php' ], // R31

            [ 'uri' => '/admin/clients/{id}', 'controller' => 'administration/clients/update.php', 'middleware' => [
                sanitizeClientEdit( ... ),
            ] ], // R32
        ],

        [ 'PUT',
                // middleware add/delete session cart, prg to render cart
            [ 'uri' => '/order/cart', 'controller' => 'order/cart/replace.php', 'middleware' => [
                cartRequireQuantity( ... ),
                removeMethod( ... ),
                clientRequired( ... ),
            ] ], // R33

            [ 'uri' => '/management/order/cart', 'controller' => 'management/cart/replace.php', 'middleware' => [
                matchRestockSupplier( ... ),
                restockRequireQuantity( ... ),
                removeMethod( ... ),
                restockClientRequired( ... ),
            ] ], // R34
                // middleware writes client id to sess, PRG to /order/cart
            // [ 'uri' => 'client/new', 'controller' => 'client/select.php', 'middleware' => [  ] ],
        ],
    ];

    // TODO: Fix assoc array to array conversion
    /* @throws Exception */
    #[NoReturn]
    public static function route( string $method, string $uri, array $request ) : string {

        // --------------Wildcard Routes
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
        // --------------

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

            // return button session store
            if ( $method === 'GET' ) {
                $location = $_SERVER[ 'REQUEST_URI' ] ?? $uri; // keep query string for pagination
                $navigation = SessionHelper::get( 'navigation' );

                if ( ( $navigation[ 'current' ] ?? null ) !== $location )
                    SessionHelper::set( 'navigation', [
                        'current' => $location,
                        'back' => $navigation[ 'current' ] ?? '/',
                    ] );
            }
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
// TODO: Clear cart. ✅