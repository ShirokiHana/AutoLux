<?php
    namespace middleware;

    use Closure;
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

    function restockClientRequired( array $request ) : array {
        $currentClient = $request[ 'supplier_id' ];
        if ( empty( $currentClient ) ) {
            postRedirectGet( 'management/order' );
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

    function filledRestockRequired( array $request ) : array {
        $cart = SessionHelper::get( 'restockCart' );
        if ( empty( $cart ) ) {
            postRedirectGet( 'management/order/cart?supplier_id=' . $request[ 'supplier_id' ] );
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
        return $request;
    }

    /*function quantityRequired( string $target ) { return
        function( array $request ) use ( $target ) : array {
            $quantity = intInRange( $request[ 'quantity' ] ?? null, 1, PHP_INT_MAX );
            if ( $quantity <= 0 )
                postRedirectGet( $target );
            return $request;
            };
        }*/

    function cartRequireQuantity( array $request ) : array {
        $quantity = intInRange( $request[ 'quantity' ] ?? null, 1, PHP_INT_MAX );
        if ( $quantity <= 0 )
            postRedirectGet( 'order/cart' );
        return $request;
    };

    function restockRequireQuantity( array $request ) : array {
        $quantity = intInRange( $request[ 'quantity' ] ?? null, 1, PHP_INT_MAX );
        if ( $quantity <= 0 )
            postRedirectGet( 'management/order/cart?supplier_id=' . $request[ 'supplier_id' ] );
        return $request;
    };

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