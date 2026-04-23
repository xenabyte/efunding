<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\AuditLog; //
use Flasher\Toastr\Prime\ToastrFactory;

class LoginController extends Controller
{
    public function showLogin() {
        return view('admin.auth.login');
    }

    public function login(Request $request, ToastrFactory $flasher) {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $admin = Auth::guard('admin')->user();

            AuditLog::create([
                'user_id' => $admin->id, //
                'action'  => 'Admin Login', //
                'changes' => json_encode([
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'login_at'   => now()->toDateTimeString()
                ]) //
            ]);

            $flasher->addSuccess("Welcome back, {$admin->name}! Login successful.");

            return redirect()->intended(url('/admin/home'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('email', 'remember'));
    }

    public function logout(Request $request) {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(url('/admin/login'));
    }
}