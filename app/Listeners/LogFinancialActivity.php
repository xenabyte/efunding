<?php

namespace App\Listeners;

use App\Events\PaymentVerified;
use App\Models\AuditLog;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogFinancialActivity implements ShouldQueue
{
    public function handle(PaymentVerified $event): void
    {
        $contribution = $event->contribution;

        AuditLog::create([
            'user_id' => $contribution->user_id,
            'action'  => 'FINANCIAL_TRANSACTION_VERIFIED',
            'changes' => json_encode([
                'amount' => $contribution->amount,
                'reference' => $contribution->transaction_reference,
                'gateway' => $contribution->payment_gateway,
                'timestamp' => now()->toDateTimeString(),
                'type' => $contribution->levy_id ? 'Levy' : 'Project Donation'
            ]),
        ]);
    }
}