<?php /** @noinspection PhpUnreachableStatementInspection */

use core\Database;
use core\Router;

// TODO: Complete controller guards to stop cURL/Postman shenanigans.

if ( PHP_SAPI === 'cli-server' && is_file( __DIR__ . parse_url( $_SERVER[ 'REQUEST_URI' ], PHP_URL_PATH ) ) )
    return false;

session_start();
    const BASE_PATH = __DIR__ . '/../';

    require_once BASE_PATH . 'lib/helperFunctions.php';

    $loadClasses = fn( $fn ) => spl_autoload_register( function( $class ) use ( $fn ) {
        require_once $fn( str_replace( '\\', DIRECTORY_SEPARATOR, $class ) . '.php' );
    } );

    $loadClasses( 'basePath' );

    // ----------------------Middleware

    // TODO: Compose functions.
    try {
        Database::readEnv( basePath( 'db.env' ) );
        $dsn = Database::prepareDSN( host: $_ENV[ 'DB_HOST' ], port: $_ENV[ 'DB_PORT' ], dbname: $_ENV[ 'DB_NAME' ] );
        Database::connection( $dsn, $_ENV[ 'DB_USER' ], $_ENV[ 'DB_PASSWORD' ], [ PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ] );
    } catch ( PDOException $PDOException ) {
        error_log( $PDOException->getMessage() );
        abort( new Exception( 'Unable to connect to database service' ), 503 );
    }

    // ----------------------Routing

    $path = rtrim( parse_url( $_SERVER[ 'REQUEST_URI' ] )[ 'path' ], '/' );
    $uri = $path === '' ? '/' : $path;

    $method = $_POST[ '__method' ] ?? $_SERVER[ 'REQUEST_METHOD' ];
    $request = array_replace( $_GET, $_POST );

    try {
        Router::route($method, $uri, $request);
    } catch ( PDOException $PDOException ) {
        error_log( $PDOException->getMessage() );
        abort( new Exception( 'Database service unavailable' ), 503 );
    } catch ( Exception $exception ) {
        abort( $exception, $exception->getCode() ?: 400 );
    }