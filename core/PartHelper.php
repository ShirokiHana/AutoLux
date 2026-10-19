<?php

namespace core;

class PartHelper {
    // Whitelist: column names can't be bound as parameters
    private const array OPTION_COLUMNS = [ 'brand', 'part_type' ];

    public static function isOptionColumn( string $column ) : bool {
        return in_array( $column, self::OPTION_COLUMNS, true );
    }

    // Distinct values for a column, e.g. every brand. Also usable for a <datalist>.
    public static function options( string $column ) : array {
        if ( !self::isOptionColumn( $column ) ) {
            return [];
        }
        return array_column( Database::fetch( 'All', "SELECT DISTINCT $column FROM parts ORDER BY $column" ) ?? [], $column );
    }

    // Case-insensitive match that returns the canonical DB spelling, or null
    public static function match( string $column, string $value ) : ?string {
        return array_find( self::options( $column ), fn( $option ) => strcasecmp( $option, $value ) === 0 );
    }
}