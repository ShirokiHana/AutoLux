<?php

namespace core\payment;

use lib\Validate;

class MasterCard extends PaymentMethod {
    public function renderForm() : string {
        // TODO: Implement renderForm() method.
        return '
            <label>
                Name on card
            <input id="name" name="name" type="text" autocomplete="cc-name">
            </label>
                <br>
            <label>
                Card number
                <input id="number" name="number" type="text" maxlength="16"
                       inputmode="numeric" autocomplete="cc-number"
                       placeholder="Mastercard">
            </label>
                <br>
            <label>
                Expiration date
                <input id="expiry" name="expiry" type="date"
                       placeholder="MM/YY" autocomplete="cc-exp">
            </label>
                <br>
            <label>
                CVV
                <input id="cvv" name="cvv" type="text" maxlength="3"
                       inputmode="numeric" autocomplete="cc-csc">
            </label>
        ';
    }

    public static function validateForm( array $request ) : bool {
        $name = $request[ 'name' ] ?? null;
        $number = $request[ 'number' ] ?? null;
        $cvv = $request[ 'cvv' ] ?? null;

        return is_string( $name )
            && Validate::name( $name )
            && is_string( $number )
            && preg_match( '/\A[0-9]{16}\z/', $number ) === 1
            && is_string( $cvv )
            && preg_match( '/\A[0-9]{3}\z/', $cvv ) === 1;
    }

    public function getPaymentName() : string {
        return 'MASTERCARD';
    }
}