<?php

namespace App\Services;

class PaymentManager {
    public function getGateway(string $name) {
        return match($name) {
            'paystack' => new \App\Services\Payments\PaystackService(),
            'monnify' => new \App\Services\Payments\MonnifyService(),
            'upperlink' => new \App\Services\Payments\UpperlinkService(),
            'expresspay' => new \App\Services\Payments\ExpressPayService(),
            default => throw new \Exception("Gateway not supported"),
        };
    }
}