<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace core;

use Exception;
use PDOException;
use PDOStatement;
use lib\FnArray;
use PDO;
use Throwable;

class Database extends PDO {
    private static PDO $PDO;

    // Helper procedures
    public static function readEnv( string $envPath ) : void {
        $file = file( $envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

        FnArray::map( $file, function ( $line ) {
            [ $key, $value ] = explode( '=', $line, 2 );
            putenv( "$key=$value" );
            $_ENV[ $key ] = $value;
        } );
    }

    // Helper methods
    public static function prepareDSN( ...$configuration ) : string {
        return 'mysql:' . http_build_query( $configuration, '', ';' );
    }

    /* @throws PDOException */
    public static function connection( string $dsn, ?string $username = null, ?string $password = null, ?array $options = null ) : PDO {
        return self::$PDO ??= new PDO( $dsn, $username, $password, $options );
    }

    private static function dbQuery( string $query, ?array $params = null ) : PDOStatement {
        $PDO_STATEMENT = self::$PDO->prepare( $query );
        $PDO_STATEMENT->execute( $params );
        return $PDO_STATEMENT;
    }

    public static function fetchAll( string $query, ?array $params = null ) : array | null {
        return self::dbQuery( $query, $params )->fetchAll( PDO::FETCH_ASSOC );
    }

    public static function fetchSingle( string $query, ?array $params = null ) : array | null {
        return self::dbQuery( $query, $params )->fetch( PDO::FETCH_ASSOC ) ?: null;
    }

    // TODO: Return exception or success ✅
    public static function pushData( string $query, array $params ) : int {
        $PDO_STATEMENT = self::dbQuery( $query, $params );
        return $PDO_STATEMENT->rowCount();
    }

    // --------Exposed methods
    public static function getLastInsertedId() : int {
        return ( int ) self::$PDO->lastInsertId();
    }

    public static function fetch( string $option, string $query, ?array $params = null ) : array | null {
        $fn = 'fetch' . ucwords( $option );
        return self::$fn( $query, $params );
    }

    // --------Transaction
    private static function startTransaction() : void {
        self::$PDO->beginTransaction();
    }
    private static function commitTransaction() : void {
        self::$PDO->commit();
    }
    private static function rollbackTransaction() : void {
        if ( self::$PDO->inTransaction() )
            self::$PDO->rollBack();
    }

    /**
     * @throws Throwable
     */
    public static function runTransaction( callable $fn ) : mixed {
        self::startTransaction();
        try {
            $result = $fn();
            self::commitTransaction();
            return $result;
        } catch ( Throwable $error ) {
            self::rollbackTransaction();
            throw $error;
        }
    }

    /**
     * @throws Exception
     */
    public static function checkInventory( array $cart ) : void {
        $check = fn( array $array ) : bool => Database::pushData(
            'UPDATE parts SET stock_quantity = stock_quantity - :quantity WHERE part_id = :part_id AND stock_quantity >= :required',
            [
                'quantity' => $array[ 'quantity' ],
                'required' => $array[ 'quantity' ],
                'part_id' => $array[ 'part_id' ],
            ]
        ) > 0;
        $results = array_map( $check, $cart );

        $idMissingStock = array_filter( $cart, fn( $_, $key ) => !$results[ $key ], ARRAY_FILTER_USE_BOTH )
                |> ( fn( $x ) => array_map( fn( array $array ) => $array[ 'part_id' ], $x ) )
                |> array_values( ... );
        $idMissingStock === [] || throw new Exception( 'Missing stock' );
    }

}