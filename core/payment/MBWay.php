<?php

namespace core\payment;

class MBWay extends PaymentMethod {
    public function renderForm() : string {
        // TODO: Implement renderForm() method.
        return '
            <label>
                MBWay Phone #
                <input type="tel"
                    id="mbway-id"
                    name="mbway_id"
                    maxlength="9"
                >
            </label>
        ';
    }

    public static function validateForm( array $request ) : bool {
        // TODO: Implement validateForm() method.
        $value = $request[ 'mbway_id' ] ?? '';
        return preg_match('/^9[0-9]{8}$/', $value ) === 1;
    }

    public function getPaymentName() : string {
        return 'MBWAY';
    }
}