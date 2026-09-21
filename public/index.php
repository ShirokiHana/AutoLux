<?php /** @noinspection PhpUnreachableStatementInspection */

use core\Database;
use core\Router;

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
    } catch ( PDOException $exception ) {
        // TODO: Fix exception router.
        abort( $exception, 503 );
    }

    // ----------------------Routing

    $uri = parse_url( $_SERVER[ 'REQUEST_URI' ] )[ 'path' ];
    $method = $_POST[ '__method' ] ?? $_SERVER[ 'REQUEST_METHOD' ];

    try {
        Router::route( $method, $uri );
    } catch ( Exception $exception ) {
        abort( $exception );
    }