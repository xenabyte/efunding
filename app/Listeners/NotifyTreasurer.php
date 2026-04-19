<?php

namespace App\Listeners;

namespace App\Listeners;

use App\Events\PaymentVerified;
use App\Models\User;
use App\Notifications\NewContributionAlert;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class NotifyTreasurer implements ShouldQueue
{
    public function handle(PaymentVerified $event): void
    {
        $contribution = $event->contribution;

        // Fetch all users with the treasurer role
        $treasurers = User::where('role', 'treasurer')->get();

        // Send a system notification or SMS alert
        // Notification::send($treasurers, new NewContributionAlert($contribution));
    }
}