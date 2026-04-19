<?php

namespace App\Services\Payments;
use App\Contracts\PaymentGatewayInterface;

class MonnifyService implements PaymentGatewayInterface {
    public function initialize(array $data) {
        
    }
    public function verify(string $reference) {
        
    }
}