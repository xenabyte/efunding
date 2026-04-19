<?php

namespace App\Services\Payments;
use App\Contracts\PaymentGatewayInterface;

class PaystackService implements PaymentGatewayInterface {
    public function initialize(array $data) {
        
    }
    public function verify(string $reference) {
        
    }
}