<?php 

namespace App\Listeners;

use App\Events\PaymentVerified;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class UpdateProjectBalance implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(PaymentVerified $event): void
    {
        $contribution = $event->contribution;

        // Use a Database Transaction to ensure data integrity
        DB::transaction(function () use ($contribution) {
            
            // 1. Handle Project-Specific Crowdfunding
            if ($contribution->campaign_id) {
                $campaign = $contribution->campaign;
                // Update the specific campaign's progress
                $campaign->increment('collected_amount', $contribution->amount);
                // Also update the parent project's total
                $campaign->project->increment('collected_amount', $contribution->amount);
            }

            // 2. Handle Project-Specific Funding (Direct to Project)
            elseif ($contribution->project_id) {
                $contribution->project->increment('collected_amount', $contribution->amount);
            }

            // 3. Handle Fixed Levies (General Fund)
            // If the levy is not attached to a project, we track it as association revenue
            elseif ($contribution->levy_id) {
                // Here you might update a 'General_Revenue' setting or a global association wallet
                // For now, we ensure the contribution is marked 'verified' (handled in Strategy)
            }
            
            // 4. Update the User's "Total Contributed" cache if you have one
            $contribution->user->increment('total_donated', $contribution->amount);
        });
    }
}