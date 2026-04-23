<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Flasher\Toastr\Prime\ToastrFactory;
use App\Models\{User, Contribution, Campaign, Expenditure, AuditLog};

class MemberController extends Controller
{
    public function residents() {
        $members = User::where('member_type', 'resident')->latest()->get();
        return view('admin.members.index', compact('members'))->with('title', 'Resident Members');
    }

    public function diaspora() {
        $members = User::where('member_type', 'diaspora')->latest()->get();
        return view('admin.members.index', compact('members'))->with('title', 'Diaspora Members');
    }

    public function all() {
        $members = User::latest()->get();
        return view('admin.members.index', compact('members'))->with('title', 'All Members');
    }

    public function store(Request $request, ToastrFactory $flasher)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'member_type' => 'required|in:resident,diaspora',
        ]);

        $year = date('Y');
        $lastMember = User::withTrashed()->latest('id')->first(); // Use withTrashed to avoid duplicate IDs
        $nextId = $lastMember ? ($lastMember->id + 1) : 1;
        $memberCode = "ODA/{$year}/" . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'member_type' => $request->member_type,
            'member_id_code' => $memberCode,
            'role' => 'member', 
            'password' => Hash::make($request->password ?? '12345678'),
        ]);

        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Registered Member: ' . $user->member_id_code,
            'changes' => json_encode(['email' => $user->email, 'type' => $user->member_type])
        ]);

        $flasher->addSuccess("Member {$memberCode} registered successfully!");
        return back();
    }

    public function update(Request $request, $id, ToastrFactory $flasher)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string|max:20',
            'member_type' => 'required|in:resident,diaspora',
        ]);

        $oldData = $user->only(['name', 'email', 'phone', 'member_type']);
        $user->update($request->all());

        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Updated Member: ' . $user->member_id_code,
            'changes' => json_encode(['from' => $oldData, 'to' => $request->only(['name', 'email', 'phone', 'member_type'])])
        ]);

        $flasher->addInfo("Member details updated.");
        return back();
    }

    /**
     * Complete the Reset Password Functionality
     */
    public function resetPassword($id, ToastrFactory $flasher)
    {
        $user = User::findOrFail($id);
        $defaultPassword = '12345678'; // You can also use a random string here

        $user->update([
            'password' => Hash::make($defaultPassword)
        ]);

        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Reset Password: ' . $user->member_id_code,
            'changes' => json_encode(['ip' => request()->ip()])
        ]);

        $flasher->addWarning("Password for {$user->member_id_code} has been reset to default (12345678).");
        return back();
    }

    public function destroy($id, ToastrFactory $flasher)
    {
        $user = User::findOrFail($id);
        $memberCode = $user->member_id_code;

        AuditLog::create([
            'user_id' => Auth::guard('admin')->id(),
            'action' => 'Deleted Member: ' . $memberCode,
            'changes' => json_encode(['deleted_data' => $user->email])
        ]);

        $user->delete();

        $flasher->addWarning("Member $memberCode has been deleted.");
        return back();
    }
}