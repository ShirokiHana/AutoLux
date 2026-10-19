<?php

use core\SessionHelper;

    // Trial session login, might be cut.

    $email = trim( $request[ 'login-email' ] ?? $request[ 'email' ] ?? '' );
    $password = $request[ 'login-password' ] ?? $request[ 'password' ] ?? '';

    $base = rtrim( $_ENV[ 'NODE_URL' ] ?? 'http://localhost:3030', '/' );
    $cURL = curl_init( "$base/login" );

    curl_setopt_array( $cURL, [
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode( [
            'email' => $email,
            'password' => $password,
        ] ),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json',
            'Accept: application/json',
        ],
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => false,
        CURLOPT_CONNECTTIMEOUT => 2,
        CURLOPT_TIMEOUT => 5,
    ] );

    $body = curl_exec( $cURL );
    $status = curl_getinfo( $cURL, CURLINFO_RESPONSE_CODE );
    $error = curl_error( $cURL );

    if ( $body === false ) {
        SessionHelper::flashInit( 'errors', [ 'email' => "Auth service unreachable: $error" ] );
        postRedirectGet( '' );
    }

    $response = json_decode( $body, true ) ?? [];
    $jwt = $response[ 'token' ] ?? $response[ 'jwt' ] ?? null;

    if ( $status !== 200 || empty( $jwt ) ) {
        $message = $response[ 'message' ] ?? $response[ 'error' ] ?? 'Invalid credentials';
        SessionHelper::flashInit( 'errors', [ 'email' => $message ] );
        postRedirectGet( '' );
    }

    $_SESSION[ 'jwt' ] = $jwt;
    SessionHelper::set( 'auth', [
        'token' => $jwt,
        'email' => $email,
        ...( ( array ) ( $response[ 'user' ] ?? [] ) ),
    ] );

    postRedirectGet( 'inventory' );