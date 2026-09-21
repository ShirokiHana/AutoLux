<?php /** @noinspection PhpPropertyOnlyWrittenInspection */

namespace core;

use http\Exception\RuntimeException;
use JetBrains\PhpStorm\NoReturn;
use PDOException;
use PDOStatement;
use lib\FnArray;
use PDO;

class Database extends PDO {
    private static PDO $PDO;

    public static function readEnv( string $envPath ) : void {
        $file = file( $envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES );

        FnArray::map( $file, function ( $line ) {
            [ $key, $value ] = explode( '=', $line, 2 );
            putenv( "$key=$value" );
            $_ENV[ $key ] = $value;
        } );
    }

    public static function prepareDSN( ...$configuration ) : string {
        return 'mysql:' . http_build_query( $configuration, '', ';' );
    }

    /* @throws PDOException */
    public static function connection( string $dsn, ?string $username = null, ?string $password = null, ?array $options = null ) : PDO {
        return self::$PDO ??= new PDO( $dsn, $username, $password, $options );
    }

    private static function dbQuery( string $query, ?array $params = null ) : PDOStatement | null {
        $PDO_STATEMENT = self::$PDO->prepare( $query );
        return $PDO_STATEMENT->execute( $params ) ? $PDO_STATEMENT : null;
    }

    public static function fetchAll( string $query, ?array $params = null ) : array | null {
        return self::dbQuery( $query, $params )->fetchAll( PDO::FETCH_ASSOC ) ?? null;
    }

    public static function fetchSingle( string $query, ?array $params = null ) : array | null {
        return self::dbQuery( $query, $params )->fetch( /* PDO::FETCH_DEFAULT */ ) ?? null;
    }

    public static function pushData( string $query, array $params ) : void { // TODO: Return exception or success
        self::dbQuery( $query, $params );
    }
}