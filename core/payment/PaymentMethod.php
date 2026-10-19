<?php

namespace core\payment;

abstract class PaymentMethod {
    private const array MAP = [
        '1' => VISA::class,
        '2' => MasterCard::class,
        '3' => MBWay::class,
    ];

    public function __construct( public string $payment_method_id  ) { }

    public static function output( string $id ) : ?static {
        $class = self::MAP[ strtoupper( $id ) ] ?? null;
        return $class
            ? new $class( $id )
            : null;
    }

    public abstract function renderForm();
    public static abstract function validateForm( array $request );
    public abstract function getPaymentName();
}

