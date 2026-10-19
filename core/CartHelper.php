<?php

namespace core;

use lib\FnArray;

class CartHelper {
    private static array $cart;

    public static function set( array $data ) : array {
        return self::$cart ??= $data;
    }

    public static function getCartState() : array {
        return self::$cart;
    }

    public static function getRenderingOptions( array $options ) : array {
        $newOptions = FnArray::slice( $options, 1 );
        return [ ...$newOptions, 'quantity', 'price' ];
    }

    public static function getDefaultRenderingOptions() : array {
        return [ 'part_type', 'brand', 'part_name', 'quantity', 'price' ];
    }

    // Helper methods
    public static function fetchPartPrice( string $part_id ) : string {
        $row = Database::fetch( 'Single', 'SELECT price FROM parts WHERE part_id = ?', [ $part_id ] );
        return $row[ 'price' ];
    }
}