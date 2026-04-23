<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Campaign, Project, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flasher\Toastr\Prime\ToastrFactory;

class CampaignController extends Controller
{
    /**
     * Display a listing of campaigns with their associated projects.
     */
    public function index()
    {
        $campaigns = Campaign::with('project')->withCount('contributions')->latest()->get();
        $projects = Project::where('status', '!=', 'completed')->get(); 
        return view('admin.campaigns.index', compact('campaigns', 'projects'));
    }

    /**
     * Store a newly created campaign.
     */
    public function store(Request $request, ToastrFactory $flasher)
    {
        $data = $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string|max:255',
            'goal_amount' => 'required|numeric|min:1',
        ]);

        $campaign = Campaign::create([
            'project_id' => $request->project_id,
            'title' => $request->title,
            'goal_amount' => $request->goal_amount,
            'is_active' => true
        ]);

        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Launched Campaign: ' . $campaign->title,
            'changes' => json_encode($data)
        ]);

        $flasher->addSuccess("Fundraising campaign launched successfully!");
        return back();
    }

    /**
     * Update the specified campaign (Edit Modal).
     */
    public function update(Request $request, Campaign $campaign, ToastrFactory $flasher)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'goal_amount' => 'required|numeric',
            'is_active' => 'required|boolean'
        ]);

        $campaign->update($data);

        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Updated Campaign: ' . $campaign->title,
            'changes' => json_encode($data)
        ]);

        $flasher->addInfo("Campaign updated.");
        return back();
    }

    /**
     * Remove the campaign (Soft Delete).
     */
    public function destroy(Campaign $campaign, ToastrFactory $flasher)
    {
        $title = $campaign->title;
        $campaign->delete();

        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Deleted Campaign: ' . $title
        ]);

        $flasher->addWarning("Campaign removed.");
        return back();
    }
}