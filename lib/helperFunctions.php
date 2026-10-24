<?php

use core\NodeClient;
use JetBrains\PhpStorm\NoReturn;
use lib\FnArray;

function screen( $var ) : void {
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

    /*function pageURL( string $uri, array $request, int $page ) : string {
        $keep = array_intersect_key( $request, array_flip( [ 'inventory-filter', 'input-search', 'inventory-filter-range' ] ) );
        return $uri . '?' . http_build_query( [ ...$keep, 'page' => $page ] );
    }*/

    function buildQuery( array $overrides = [], array $remove = [] ) : string {
        $query = [ ...$_GET, ...$overrides ];
        // Any change other than an explicit page resets to page 1 (mirrored in public/js/query.js).
        if ( $overrides && !isset( $overrides[ 'page' ] ) )
            unset( $query[ 'page' ] );
        $query = array_diff_key( $query, array_flip( $remove ) );
        $query = array_filter( $query, fn( $value ) => $value !== '' && $value !== null );
        return $query ? '?' . http_build_query( $query ) : '';
    }

    function basePath( $path ) : string {
        return BASE_PATH . $path;
    }

    #[NoReturn]
    function postRedirectGet( string $location ) : NoReturn {
        header( "location: /$location" );
        exit();
    }

    function mergeCartState( array | null $staleState, string $sessionKey = 'cart' ) : Closure {
        return function( array $newState ) use ( $staleState, $sessionKey ) : void {
            $key = FnArray::removeKey( $newState, 'quantity' )
                    |> array_values( ... )
                    |> ( fn( $x ) => FnArray::map( $x, fn( $entry ) => str_replace( ' ', '', $entry ) ) )
                    |> ( fn( $x ) => implode( '-', $x ) );

            $entryExists = $staleState[ $key ] ?? [ ...$newState, 'quantity' => 0 ];
            $_SESSION[ $sessionKey ][ $key ] = [
                ...$entryExists,
                'quantity' => $entryExists[ 'quantity' ] + $newState[ 'quantity' ]
            ];
        };
    }

    function loadNodeHTML( string $path ) {
        try {
            return NodeClient::fragment( NodeClient::get( $path ) );
        } catch ( Exception $exception ) {
            abort( $exception, 502 );
        }
    }

    function formatStringLabel( string $string ) : string {
        return ucwords( str_replace( [ 'part_', '_' ], [ '', ' ' ], $string ) );
    }

    function callStack( callable ...$fns ) : Closure {
        return function ( mixed $x ) use ( $fns ) : mixed {
            foreach ( array_reverse( $fns ) as $fn ) {
                $x = $fn( $x );
            }
            return $x;
        };
    }