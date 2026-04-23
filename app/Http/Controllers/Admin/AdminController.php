<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Contribution, Project, Campaign, User, Expenditure, AuditLog};




class AdminController extends Controller
{
    //

    public function home()
    {
        // Financial Summaries
        $totalIncome = Contribution::where('status', 'success')->sum('amount');
        $totalExpense = Expenditure::sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Membership Stats
        $memberCount = User::count();
        $residentCount = User::where('member_type', 'resident')->count();
        $diasporaCount = User::where('member_type', 'diaspora')->count();

        // Project Progress
        $activeProjects = Project::where('status', 'ongoing')->count();
        $completedProjects = Project::where('status', 'completed')->count();

        // Recent Transactions for the dashboard table
        $recentContributions = Contribution::with('user')->latest()->take(5)->get();

        return view('admin.home', compact(
            'totalIncome', 'totalExpense', 'balance', 
            'memberCount', 'residentCount', 'diasporaCount',
            'activeProjects', 'completedProjects', 'recentContributions'
        ))->with('title', 'Admin Dashboard');
    }

    public function auditLogs()
    {
        // Fetch logs with the user who performed the action
        $logs = AuditLog::with('user')->latest()->get();
        
        return view('admin.audit.index', compact('logs'))->with('title', 'System Audit Logs');
    }
}
