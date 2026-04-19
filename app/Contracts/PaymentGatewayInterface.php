<?php

namespace App\Contracts;

interface PaymentGatewayInterface {
    public function initialize(array $data);
    public function verify(string $reference);
}