<?php 

namespace App\Repositories;
use App\Models\Contribution;

class ContributionRepository {
    public function getProjectFundingStats($projectId) {
        return Contribution::where('project_id', $projectId)
            ->where('status', 'success')
            ->selectRaw('SUM(amount) as total, COUNT(id) as donors')
            ->first();
    }

    public function getMemberOutstandingBalance($userId) {
       
    }
}