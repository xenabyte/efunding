<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;

Route::prefix('admin')->name('admin.')->group(function () {

    /**
     * Entry Point: /admin
     * Redirects to home if authenticated, otherwise Middleware kicks to login.
     */
    Route::get('/', function() {
        return redirect()->route('admin.home');
    })->middleware(['web', 'auth.admin']);

    // This prevents logged-in users from seeing the login/register forms
    Route::middleware(['web', 'guest.admin'])->group(function () {
        Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);
    });

    // PUBLIC BUT NO REDIRECT
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.request');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    // PROTECTED ROUTES
    Route::middleware(['web', 'auth.admin'])->group(function () {
        Route::get('/home', function() { 
            return view('admin.home'); 
        })->name('home');
    });

});