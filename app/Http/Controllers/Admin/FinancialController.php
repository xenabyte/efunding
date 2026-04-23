<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Expenditure, Project, AuditLog, Contribution, Levy, Campaign};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Flasher\Toastr\Prime\ToastrFactory;

class FinancialController extends Controller
{
    public function levySettings()
    {
        $levies = Levy::latest()->get();
        return view('admin.financials.levies', compact('levies'))->with('title', 'Levy Settings');
    }

    public function levyStore(Request $request, ToastrFactory $flasher)
    {
        $request->validate([
            'name' => 'required|string',
            'amount' => 'required|numeric',
            'member_type' => 'required|in:all,resident,diaspora',
            'frequency' => 'required'
        ]);

        Levy::create($request->all());
        
        $flasher->addSuccess('New levy created successfully');
        return back();
    }

    public function levyDestroy($id, ToastrFactory $flasher)
    {
        $levy = Levy::findOrFail($id);
        $levy->delete();
        $flasher->addWarning('Levy configuration removed.');
        return back();
    }

    public function contributions()
    {
        $contributions = Contribution::with(['user', 'campaign', 'levy'])
                            ->latest()
                            ->get();
        
        return view('admin.financials.contributions', compact('contributions'))->with('title', 'Contributions');
    }

    public function expenditureIndex() 
    {
        $expenditures = Expenditure::with(['project', 'admin'])->latest()->get();
        $projects = Project::where('status', '!=', 'completed')->get();
        return view('admin.financials.expenditures', compact('expenditures', 'projects'))->with('title', 'Expenditure Logs');
    }

    public function expenditureStore(Request $request, ToastrFactory $flasher) 
    {
        $request->validate([
            'project_id' => 'required|exists:projects,id',
            'title' => 'required|string',
            'amount' => 'required|numeric',
            'date_spent' => 'required|date',
            'receipt_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->except('receipt_image');
        $data['admin_id'] = Auth::guard('admin')->id();

        // Handle Receipt Upload
        if ($request->hasFile('receipt_image')) {
            $imageName = time().'.'.$request->receipt_image->extension();  
            $request->receipt_image->move(public_path('uploads/receipts'), $imageName);
            $data['receipt_image'] = 'uploads/receipts/'.$imageName;
        }

        $expenditure = Expenditure::create($data);

        // Audit Log
        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Recorded Expenditure: ' . $expenditure->title,
            'changes' => json_encode(['amount' => $expenditure->amount, 'project' => $expenditure->project->title])
        ]);

        $flasher->addSuccess('Expenditure recorded and logged.');
        return redirect()->route('admin.financial.expenditure.index');
    }

    public function reports(Request $request)
    {
        // Optional: Add date filtering logic here if needed for your defense
        $income = Contribution::where('status', 'success')->sum('amount');
        $expense = Expenditure::sum('amount');
        $surplus = $income - $expense;

        // Get data for the breakdown tables
        $campaignBreakdown = Campaign::withSum(['contributions' => function($query) {
            $query->where('status', 'success');
        }], 'amount')->get();

        $projectBreakdown = Project::withSum('expenditures', 'amount')->get();

        return view('admin.financials.reports', compact(
            'income', 'expense', 'surplus', 
            'campaignBreakdown', 'projectBreakdown'
        ))->with('title', 'Financial Statement');
    }
}