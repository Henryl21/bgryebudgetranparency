<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\LoginController;
use App\Http\Controllers\Admin\Auth\RegisterController;
use App\Http\Controllers\Admin\BudgetController;
use App\Http\Controllers\Admin\IncomeController;
use App\Http\Controllers\Admin\ExpenditureController;
use App\Http\Controllers\Admin\OfficerApprovalController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\BarangaySettingController;
use App\Http\Controllers\Admin\FeedbackController as AdminFeedbackController;
use App\Http\Controllers\Officer\OfficerAuthController;
use App\Http\Controllers\Officer\OfficerDashboardController;
use App\Http\Controllers\Treasurer\TreasurerAuthController;
use App\Http\Controllers\Treasurer\TreasurerDashboardController;
use App\Http\Controllers\User\FeedbackController as UserFeedbackController;
use App\Http\Controllers\Admin\UserController; // ✅ added for officer list

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
})->name('welcome');

// Redirect users to proper dashboards depending on guard
Route::get('/dashboard', function () {
    if (auth('admin')->check()) {
        return redirect()->route('admin.dashboard');
    } elseif (auth('officer')->check()) {
        return redirect()->route('officer.dashboard');
    } elseif (auth('treasurer')->check()) {
        return redirect()->route('treasurer.dashboard');
    }
    return redirect()->route('welcome');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Authentication
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::get('/admin/register', [RegisterController::class, 'showRegisterForm'])->name('admin.register');
Route::post('/admin/register', [RegisterController::class, 'register']);

Route::get('/admin/otp', [LoginController::class, 'showOtpForm'])->name('admin.otp.form');
Route::post('/admin/otp', [LoginController::class, 'verifyOtp'])->name('admin.otp.verify');
Route::post('admin/otp/resend', [LoginController::class, 'resendOtp'])->name('admin.otp.resend');

// Redirect legacy upload-receipt route
Route::get('/admin/expenditure/{id}/upload-receipt', function ($id) {
    return redirect("/admin/expenditures/{$id}/upload-receipt");
});

/*
|--------------------------------------------------------------------------
| Admin Protected Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth:admin'])->group(function () {

    Route::get('/admin/database', [AdminDashboardController::class, 'showDatabasePage'])->name('database');
    Route::get('/admin/download-database', [AdminDashboardController::class, 'downloadDatabase'])->name('downloadDatabase');

    // ✅ Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/budget-dashboard', [BudgetController::class, 'dashboard'])->name('budget.dashboard');

    Route::post('/admin/logout', [AdminDashboardController::class, 'logout'])->name('logout');

    // ✅ Users list route (for admin to view all registered users)
    Route::get('/users-officers', [UserController::class, 'index'])->name('users_officers.index');
    Route::get('users-officers/{email}', [\App\Http\Controllers\Admin\UserController::class, 'show'])->name('users_officers.show');
    Route::get('/activity-logs', [UserController::class, 'activityLogs'])->name('activity.logs');

    // ✅ Admin Profile
    Route::get('/profile', [AdminProfileController::class, 'show'])->name('profile.show');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');

    // ✅ Barangay Settings
    Route::resource('barangay_settings', BarangaySettingController::class)
        ->only(['index', 'create', 'edit', 'update', 'store']);

    // ✅ Reports
    Route::resource('settings/reports', ReportController::class);
    Route::get('/reports/expenditures', [ReportController::class, 'printExpenditures'])->name('reports.print');

    // ✅ Budget CRUD
    Route::resource('/budget', BudgetController::class);
    Route::get('/budget/{budget}/receipt', [BudgetController::class, 'showReceipt'])->name('budget.showReceipt');
    Route::post('/officers/{id}/approve', [OfficerApprovalController::class, 'approve'])->name('officers.approve');
    Route::post('/officers/{id}/decline', [OfficerApprovalController::class, 'decline'])->name('officers.decline');
    Route::post('/officers/{id}/budget-approve', [OfficerApprovalController::class, 'approveBudgetRequest'])->name('officers.approve');
    Route::post('/officers/{id}/budget-decline', [OfficerApprovalController::class, 'declineBudgetRequest'])->name('officers.decline');

    // ✅ Income CRUD
    Route::get('/incomes', [IncomeController::class, 'index'])->name('income.index');
    Route::get('/incomes/create', [IncomeController::class, 'create'])->name('income.create');
    Route::post('/incomes', [IncomeController::class, 'store'])->name('income.store');
    Route::get('/incomes/{id}/edit', [IncomeController::class, 'edit'])->name('income.edit');
    Route::put('/incomes/{id}', [IncomeController::class, 'update'])->name('income.update');
    Route::delete('/incomes/{id}', [IncomeController::class, 'destroy'])->name('income.destroy');

    // ✅ Expenditure CRUD
    Route::get('/expenditures', [ExpenditureController::class, 'index'])->name('expenditure.index');
    Route::get('/expenditures/create', [ExpenditureController::class, 'create'])->name('expenditure.create');
    Route::post('/expenditures', [ExpenditureController::class, 'store'])->name('expenditure.store');
    Route::get('/expenditures/{id}/edit', [ExpenditureController::class, 'edit'])->name('expenditure.edit');
    Route::put('/expenditures/{id}', [ExpenditureController::class, 'update'])->name('expenditure.update');
    Route::delete('/expenditures/{id}', [ExpenditureController::class, 'destroy'])->name('expenditure.destroy');

    // ✅ Expenditure Receipts
    Route::get('/expenditures/{id}/view-receipt', [ExpenditureController::class, 'showReceipt'])->name('expenditure.showReceipt');
    Route::get('/expenditures/{id}/serve-receipt', [ExpenditureController::class, 'serveReceipt'])->name('expenditure.serveReceipt');
    Route::get('/expenditures/{id}/download-receipt', [ExpenditureController::class, 'downloadReceipt'])->name('expenditure.downloadReceipt');
    Route::post('/expenditures/{id}/upload-receipt', [ExpenditureController::class, 'storeReceipt'])->name('expenditure.storeReceipt');

    // ✅ Officer Approvals
    Route::get('/officers/approval', [OfficerApprovalController::class, 'index'])->name('officers.approval');
    Route::post('/officers/{id}/approve', [OfficerApprovalController::class, 'approve'])->name('officers.approve');
    Route::post('/officers/{id}/decline', [OfficerApprovalController::class, 'decline'])->name('officers.decline');
    Route::get('/officers/{id}/view-resolution', [OfficerApprovalController::class, 'viewResolution'])->name('officers.viewResolution');

    // ✅ Announcements
    Route::resource('announcements', AnnouncementController::class);

    // ✅ Feedback (Admin viewing only)
    Route::get('/feedback', [AdminFeedbackController::class, 'index'])->name('feedback.index');
});

/*
|--------------------------------------------------------------------------
| Officer Authentication
|--------------------------------------------------------------------------
*/
Route::prefix('officer')->name('officer.')->group(function () {
    // Registration
    Route::get('/register', [OfficerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [OfficerAuthController::class, 'register'])->name('register.submit');

    // Registration OTP
    Route::get('/register/otp', [OfficerAuthController::class, 'showRegisterOtp'])->name('register.otp');
    Route::post('/register/otp', [OfficerAuthController::class, 'verifyRegisterOtp'])->name('register.verifyOtp');

    // Login
    Route::get('/login', [OfficerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [OfficerAuthController::class, 'login'])->name('login.submit');

    // Login OTP
    Route::get('/otp', [OfficerAuthController::class, 'showOtp'])->name('otp');
    Route::post('/otp', [OfficerAuthController::class, 'verifyOtp'])->name('verifyOtp');

    // Logout
    Route::post('/logout', [OfficerAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Officer Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:officer'])->prefix('officer')->name('officer.')->group(function () {
    // ✅ Officer Dashboard
    Route::get('/dashboard', [OfficerDashboardController::class, 'index'])->name('dashboard');

    // ✅ Store Expenditure Request
    Route::post('/expenditures/store', [OfficerDashboardController::class, 'store'])->name('expenditures.store');

    // ✅ Edit Expenditure Request
    Route::get('/expenditures/{id}/edit', [OfficerDashboardController::class, 'edit'])->name('expenditures.edit');

    // ✅ Update Expenditure Request
    Route::put('/expenditures/{id}', [OfficerDashboardController::class, 'update'])->name('expenditures.update');

    // ✅ Delete Expenditure Request
    Route::delete('/expenditures/{id}', [OfficerDashboardController::class, 'destroy'])->name('expenditures.destroy');
});

/*
|--------------------------------------------------------------------------
| ⭐ TREASURER AUTHENTICATION
|--------------------------------------------------------------------------
*/
Route::prefix('treasurer')->name('treasurer.')->group(function () {

    // Registration
    Route::get('/register', [TreasurerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [TreasurerAuthController::class, 'register'])->name('register.submit');

    // Registration OTP
    Route::get('/register/otp', [TreasurerAuthController::class, 'showRegisterOtp'])->name('register.otp');
    Route::post('/register/otp', [TreasurerAuthController::class, 'verifyRegisterOtp'])->name('register.verifyOtp');

    // Login
    Route::get('/login', [TreasurerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [TreasurerAuthController::class, 'login'])->name('login.submit');

    // Login OTP
    Route::get('/otp', [TreasurerAuthController::class, 'showOtp'])->name('otp');
    Route::post('/otp', [TreasurerAuthController::class, 'verifyOtp'])->name('verifyOtp');

    // Logout
    Route::post('/logout', [TreasurerAuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| ⭐ TREASURER PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:treasurer'])
    ->prefix('treasurer')
    ->name('treasurer.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [TreasurerDashboardController::class, 'index'])->name('dashboard');

        // (Optional future CRUD)
        // Route::resource('/reports', TreasurerReportController::class);
    });

/*
|--------------------------------------------------------------------------
| User Feedback (Authenticated Users)
|--------------------------------------------------------------------------
*/
// Route::middleware(['auth'])->group(function () {
//     Route::get('/feedback', [UserFeedbackController::class, 'index'])->name('feedback.index');   
//     Route::get('/feedback/create', [UserFeedbackController::class, 'create'])->name('user.feedback.create'); 
//     Route::post('/feedback', [UserFeedbackController::class, 'store'])->name('user.feedback.store');  
//     Route::delete('/feedback/{id}', [UserFeedbackController::class, 'destroy'])->name('user.feedback.destroy'); 
// });
