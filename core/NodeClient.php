<?php /** @noinspection PhpMultipleClassDeclarationsInspection */

namespace core;

use Exception;
use JsonException;

class NodeClient {
    public static function request(
        string $method,
        string $path,
        ?array $payload = null
    ) : array | null {
        $base = rtrim( $_ENV[ 'NODE_URL' ] ?? 'http://localhost:3030', '/' );
        $curl = curl_init( $base . $path );

        $headers = [ 'Accept: application/json' ];
        $options = [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_TIMEOUT => 5,
            CURLOPT_CUSTOMREQUEST => strtoupper( $method ),
        ];

        if ( $payload !== null ) {
            $headers[] = 'Content-Type: application/json';
            $options[ CURLOPT_POSTFIELDS ] = json_encode( $payload, JSON_THROW_ON_ERROR );
        }

        $options[ CURLOPT_HTTPHEADER ] = $headers;
        curl_setopt_array( $curl, $options );

        $body = curl_exec( $curl );
        $status = curl_getinfo( $curl, CURLINFO_RESPONSE_CODE );
        $error = curl_error( $curl );

        if ( $body === false )
            throw new Exception( "Supplier service unavailable: $error", 502 );

        if ( $status < 200 || $status >= 300 )
            throw new Exception( trim( $body ) ?: "Supplier service returned HTTP $status", $status );

        if ( $status === 204 || $body === '' )
            return null;

        try {
            $response = json_decode( $body, true, 512, JSON_THROW_ON_ERROR );
        } catch ( JsonException $exception ) {
            throw new Exception( 'Unexpected supplier service response', 502, $exception );
        }

        if ( !is_array( $response ) )
            throw new Exception( 'Unexpected supplier service response', 502 );

        return $response;
    }

    /**
     * @throws Exception
     */
    public static function get( string $path ) : string {
        // no trailing slash
        $base = rtrim( $_ENV[ 'NODE_URL' ] ?? 'http://localhost:3030', '/' );
        $cURL = curl_init( $base . $path );

        curl_setopt_array( $cURL, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_CONNECTTIMEOUT => 2,
            CURLOPT_TIMEOUT => 5,
        ] );

        $body = curl_exec( $cURL );
        $status = curl_getinfo( $cURL, CURLINFO_RESPONSE_CODE );
        $error = curl_error( $cURL );

        if ( $body === false )
            throw new Exception( "Restock service unreachable: $error" );
        if ( $status !== 200 )
            throw new Exception( "Restock service returned HTTP $status" );
        return $body;
    }

    // Keep what's inside <body> plus the script Node emits after </body>

    /**
     * @throws Exception
     */
    public static function fragment(string $html ) : string {
        if ( !preg_match( '~<body[^>]*>(.*)</html>~is', $html, $match ) )
            throw new Exception( 'Unexpected restock page' );
        return str_ireplace( '</body>', '', $match[ 1 ] );
    }
}