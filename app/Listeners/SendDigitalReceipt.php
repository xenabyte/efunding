<?php

namespace App\Listeners;

use App\Events\PaymentVerified;
use App\Mail\ContributionReceiptMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendDigitalReceipt implements ShouldQueue
{
    public function handle(PaymentVerified $event): void
    {
        $contribution = $event->contribution;
        $user = $contribution->user;

        // Send the receipt email
        // Mail::to($user->email)->send(new ContributionReceiptMail($contribution));
    }
}
