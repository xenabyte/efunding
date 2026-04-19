<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\Auth\LoginController;
use App\Http\Controllers\User\Auth\RegisterController;
use App\Http\Controllers\User\Auth\ForgotPasswordController;
use App\Http\Controllers\User\Auth\ResetPasswordController;

Route::prefix('user')->name('user.')->group(function () {

    /**
     * Entry Point: /user
     * Redirects to home if authenticated, otherwise Middleware kicks to login.
     */
    Route::get('/', function() {
        return redirect()->route('user.home');
    })->middleware(['web', 'auth.user']);

    // This prevents logged-in users from seeing the login/register forms
    Route::middleware(['web', 'guest.user'])->group(function () {
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
    Route::middleware(['web', 'auth.user'])->group(function () {
        Route::get('/home', function() { 
            return view('user.home'); 
        })->name('home');
    });

});