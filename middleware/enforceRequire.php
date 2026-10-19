<?php
    namespace middleware;

    use core\payment\PaymentMethod;
    use core\SessionHelper;
    use lib\FnArray;

    // TODO: Flash errors per middleware with errors

    function clientRequired( array $request ) : array {
        // implode( '', SessionHelper::get( 'client' ) )
        $currentClient = SessionHelper::get( 'client' );
        if ( empty( $currentClient[ 0 ] ) ) {
            postRedirectGet( 'order' );
        }
        return $request;
    }

    function filledCartRequired( array $request ) : array {
        $cart = SessionHelper::get( 'cart' );
        if ( empty( $cart ) ) {
            postRedirectGet( 'order/cart' );
        }
        return $request;
    }

    function receiptRequired( array $request ) : array {
        $receipt = SessionHelper::getFlash( 'receipt' );
        if ( empty( $receipt ) ) {
            postRedirectGet( 'order' );
        }
        return $request;
    }

    function supplierRequired( array $request ) : array {
        $id = intInRange( $request[ 'supplier_id' ] ?? null, 1, PHP_INT_MAX );
        if ( $id === false )
            postRedirectGet( 'management/order' );
        return [ ...$request, 'supplier_id' => $id ];
    }

    function restockReceiptRequired( array $request ) : array {
        if ( empty( SessionHelper::getFlash( 'restock' ) ) )
            postRedirectGet( 'management/order' );
        return $request;
    }

    function paymentRequired( array $request ) : array {
        $method = FnArray::removeKey( $request, 'method_id' );
        if ( array_any( $method, fn( $value ) => empty( $value ) ) ) {
            SessionHelper::flashInit( 'errors', [ 'payment' => 'Please fill correctly!' ] );
            postRedirectGet( 'order/payment?payment_method=' . urlencode( PaymentMethod::output( $request[ 'method-id' ] )->getPaymentName() ) );
        }
        return $request;
    }