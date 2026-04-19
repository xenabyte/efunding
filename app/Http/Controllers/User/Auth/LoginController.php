<?php
namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin() {
        return view('user.auth.login');
    }

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::guard('user')->attempt($request->only('email','password'), $request->filled('remember'))) {
            return redirect()->intended(url('/user/home'));
        }

        return back()->withErrors(['email' => 'Invalid credentials.'])->withInput($request->only('email','remember'));
    }

    public function logout(Request $request) {
        Auth::guard('user')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(url('/user/login'));
    }
}