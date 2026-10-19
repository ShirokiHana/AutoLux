<?php

namespace core;

use lib\FnArray;

class SessionHelper {
    public static function get( string $key ) : array {
        return ( array )( $_SESSION[ $key ] ?? [] );
    }

    public static function getFlash( string $key ) : array {
        return ( array )( $_SESSION[ '__flash' ][ $key ] ?? [] );
    }

    // Method only creates if $key is unset, no overwriting ??=
    public static function set( string $key, array $value ) : void {
        $_SESSION[ $key ] = $value;
    }

    public static function flashInit( string $key, array $value ) : void {
        $_SESSION[ '__flash' ][ $key ] = $value;
    }

    public static function unflash( string $key ) : void {
        unset( $_SESSION[ '__flash' ][ $key ] );
    }

    public static function unflashSession() : void {
        unset( $_SESSION[ '__flash' ] );
    }
}