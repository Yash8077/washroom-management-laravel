<?php

use Illuminate\Support\Facades\Route;
// Admin Controllers
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LocationController as AdminLocationController;
use App\Http\Controllers\Admin\TaskController as AdminTaskController;
use App\Http\Controllers\Admin\IssueController as AdminIssueController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
// Staff Controllers
use App\Http\Controllers\Staff\DashboardController as StaffDashboardController;
use App\Http\Controllers\Staff\TaskController as StaffTaskController;
use App\Http\Controllers\Staff\IssueController as StaffIssueController;
// Public Controllers
use App\Http\Controllers\Public\IssueReportController;
// General Controllers
use App\Http\Controllers\WashroomStatusController;
use App\Http\Controllers\ProfileController; // Assuming Breeze for profile

// Default Welcome Route (Optional)
Route::get('/', function () {
    // Redirect to login or a public dashboard if preferred
    return view('welcome');
});

// Public Issue Reporting
Route::get('/report-issue', [IssueReportController::class, 'create'])->name('public.issues.create');
Route::post('/report-issue', [IssueReportController::class, 'store'])->name('public.issues.store');

// Public Washroom Status View (Optional)
Route::get('/washrooms/status', [WashroomStatusController::class, 'index'])->name('public.washrooms.status');
Route::get('/washrooms/{washroom}', [WashroomStatusController::class, 'show'])->name('public.washrooms.show'); // Show public details

// Authenticated Routes Group
Route::middleware(['auth', 'verified'])->group(function () { // 'verified' is optional (email verification)

    // Redirect based on role after login/verification or direct dashboard access
    Route::get('/dashboard', function () {
        $user = auth()->user();
        if ($user->isAdmin()) { // Assumes isAdmin() helper method on User model
            return redirect()->route('admin.dashboard');
        } elseif ($user->isStaff()) { // Assumes isStaff() helper method on User model
             return redirect()->route('staff.dashboard');
        }
        // Fallback dashboard or redirect to profile/login
        // You might want a generic dashboard or redirect non-admin/staff users elsewhere
        return redirect('/login'); // Or maybe profile page
    })->name('dashboard'); // Generic dashboard route name often used by Breeze/Jetstream

    // Profile routes (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Admin Routes
    // Requires 'auth' and 'role:admin' middleware
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::resource('locations', AdminLocationController::class); // Manages Buildings/Floors/Washrooms via one controller (adjust as needed)
        Route::resource('tasks', AdminTaskController::class);
        Route::resource('issues', AdminIssueController::class)->except(['create', 'store']); // Admin manages existing issues
        Route::resource('users', AdminUserController::class); // Manage users
        Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
        // Add specific routes for different reports if needed
        // Route::get('/reports/task-completion', [AdminReportController::class, 'taskCompletion'])->name('reports.task-completion');
    });

    // Staff Routes
    // Requires 'auth' and 'role:staff' middleware
    Route::middleware(['role:staff'])->prefix('staff')->name('staff.')->group(function () {
        Route::get('/dashboard', [StaffDashboardController::class, 'index'])->name('dashboard');
        // Task routes for staff
        Route::get('/tasks', [StaffTaskController::class, 'index'])->name('tasks.index'); // List assigned tasks
        Route::get('/tasks/{task}', [StaffTaskController::class, 'show'])->name('tasks.show'); // View task details
        Route::put('/tasks/{task}/update-status', [StaffTaskController::class, 'updateStatus'])->name('tasks.updateStatus'); // Update task status
        // Issue reporting routes for staff
        Route::get('/issues/create', [StaffIssueController::class, 'create'])->name('issues.create'); // Show form to report issue
        Route::post('/issues', [StaffIssueController::class, 'store'])->name('issues.store'); // Submit new issue report
        Route::get('/issues', [StaffIssueController::class, 'index'])->name('issues.index'); // List issues reported by staff member
    });

});

// Include default auth routes (Login, Register, Password Reset, etc.)
// This line is usually added automatically by Breeze/Jetstream installation
require __DIR__.'/auth.php';