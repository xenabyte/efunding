<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Project, AuditLog};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flasher\Toastr\Prime\ToastrFactory;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::withCount('campaigns')->withSum('expenditures', 'amount')->latest()->get();
        return view('admin.projects.index', compact('projects'));
    }

    public function store(Request $request, ToastrFactory $flasher)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'status' => 'required|in:pending,ongoing,completed',
            'description' => 'nullable|string'
        ]);

        $project = Project::create($data);

        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Created Project: ' . $project->title,
            'changes' => json_encode($data)
        ]);

        $flasher->addSuccess("Project '{$project->title}' initiated.");
        return back();
    }

    public function update(Request $request, $id, ToastrFactory $flasher)
    {
        $project = Project::findOrFail($id);
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'target_amount' => 'required|numeric',
            'status' => 'required|in:pending,ongoing,completed',
            'description' => 'nullable|string'
        ]);

        $project->update($data);

        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Updated Project: ' . $project->title,
            'changes' => json_encode($data)
        ]);

        $flasher->addInfo("Project updated successfully.");
        return back();
    }

    public function destroy($id, ToastrFactory $flasher)
    {
        $project = Project::findOrFail($id);
        
        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Deleted Project: ' . $project->title,
            'changes' => json_encode(['deleted_at' => now()])
        ]);

        $project->delete();
        $flasher->addError("Project has been moved to trash.");
        return back();
    }
}