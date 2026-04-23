<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\Auth\ForgotPasswordController;
use App\Http\Controllers\Admin\Auth\ResetPasswordController;
use App\Http\Controllers\Admin\{AdminController, MemberController, CampaignController, ProjectController, FinancialController};

Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/', function() {
        return redirect()->route('admin.home');
    })->middleware(['web', 'auth.admin']);

    Route::middleware(['web', 'guest.admin'])->group(function () {
        Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
        Route::post('/login', [LoginController::class, 'login']);
        Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
        Route::post('/register', [RegisterController::class, 'register']);
    });

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.reset');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.request');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset.form');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

    Route::middleware(['web', 'auth.admin'])->group(function () {
        Route::get('/home', [AdminController::class, 'home'])->name('home');
        Route::get('/dashboard', [AdminController::class, 'home'])->name('dashboard');
        Route::get('/audit-logs', [AdminController::class, 'auditLogs'])->name('audit.logs');

        // Community Management
        Route::prefix('members')->name('members.')->group(function () {
            Route::get('/resident', [MemberController::class, 'residents'])->name('resident');
            Route::get('/diaspora', [MemberController::class, 'diaspora'])->name('diaspora');
            Route::get('/all', [MemberController::class, 'all'])->name('all');
            Route::post('/store', [MemberController::class, 'store'])->name('store');
            Route::put('/update/{id}', [MemberController::class, 'update'])->name('update');
            Route::delete('/delete/{id}', [MemberController::class, 'destroy'])->name('delete');
            Route::post('/reset-password/{id}', [MemberController::class, 'resetPassword'])->name('reset-password');
        });

        // Development Control - Resource routes inherit the "admin." prefix
        Route::resource('projects', ProjectController::class); 
        Route::resource('campaigns', CampaignController::class);

        // Financials
        Route::name('financial.')->group(function() {
            Route::get('/levies', [FinancialController::class, 'levySettings'])->name('levies');
            Route::get('/contributions', [FinancialController::class, 'contributions'])->name('contributions');
            Route::get('/expenditure', [FinancialController::class, 'expenditureIndex'])->name('expenditure.index');
            Route::get('/expenditure/create', [FinancialController::class, 'expenditureCreate'])->name('expenditure.create');
            Route::post('/expenditure/store', [FinancialController::class, 'expenditureStore'])->name('expenditure.store');

            Route::post('/levies/store', [FinancialController::class, 'levyStore'])->name('levy.store');
            Route::delete('/levies/delete/{id}', [FinancialController::class, 'levyDestroy'])->name('levy.delete');
        });

        Route::get('/reports/financial', [FinancialController::class, 'reports'])->name('reports.financial');
        Route::get('/settings', [AdminController::class, 'settings'])->name('settings');
    });

});