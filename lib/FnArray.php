<?php /** @noinspection PhpOptionalBeforeRequiredParametersInspection */

namespace lib;

class FnArray {
    public static function flat( array $array, int $depth = PHP_INT_MAX ) : array {
        return array_reduce( $array, function( $carry, $item ) use ( $depth ) {
            if ( is_array( $item ) && $depth > 0 ) { // If array detected, merge to flatten
                return array_merge( $carry, self::flat( $item, $depth - 1 ) );
            }
            return array_merge( $carry, [ $item ] ); // Otherwise recursively carry through array
        }, [] ); // Empty array defines return type
    }

    public static function map( array $array, callable $fn ) : array {
        return array_map( $fn, $array );
    }

    public static function flatMap( array $array, callable $fn ) : array {
        return array_map( $fn, self::flat( $array, 1 ) );
    }

    public static function filter( array $array, callable $fn ) : array {
        return array_filter( $array, $fn );
    }

    public static function slice( array $array, int $offset ) : array {
        return array_slice( $array, $offset );
    }

    // Out of place array returned, save to $_SESSION
    public static function mergeState( array $staleState, int $id, int $quantity ) : array {
        return [ ...$staleState, $id => ( $staleState[ $id ] ?? 0 ) + $quantity ]; // Ensures proper addition
    }

    // Left fold state, curry mergeState, save to $_SESSION
    // Items signature [ 'id' => $, 'quantity' => $ ]
    public static function mergeAll( array $staleState, array $items ) : array {
        return array_reduce(
            $items,
            fn( $carry, $item) => self::mergeState( $carry, $item[ 'id' ], $item [ 'quantity' ] ),
            $staleState
        );
    }
}