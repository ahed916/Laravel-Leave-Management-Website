<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminLeaveController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\StaffDashboardController;
use App\Http\Controllers\CalendarEventsController;

Route::get('/',function(){
    return view('welcome');
});

Route::get('/login',[ PageController::class,'ViewLoginPageController'])->name('login');

Route::get('/dashboard', function () {
    if (auth()->user()->is_admin) {
        return redirect()->route('admin.dashboard');
    } else {
        return redirect()->route('staff.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/dashboard/filter', [AdminDashboardController::class, 'filter'])->name('admin.dashboard.filter');
    Route::get('/admin/dashboard/exportcsv', [AdminDashboardController::class, 'exportcsv'])->name('admin.dashboard.exportcsv');
    Route::get('/admin/dashboard/exportpdf', [AdminDashboardController::class, 'exportPDF'])->name('admin.dashboard.exportpdf');
});
Route::middleware(['auth','is_admin'])->group(function () {
    Route::get('/admin/calendar/events', [CalendarEventsController::class, 'admin'])->name('calendar.events.admin');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/staff/calendar/events', [CalendarEventsController::class, 'staff'])->name('calendar.events.staff');
});
Route::get('/staff/dashboard', [StaffDashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('staff.dashboard');


Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/staff-management', [UserController::class, 'index'])->name('staff.index');
    Route::get('/staff-management/create', [UserController::class, 'create'])->name('staff.create');
    Route::post('/staff-management/store', [UserController::class, 'store'])->name('staff.store');
    Route::get('/staff-management/{id}/edit', [UserController::class, 'edit'])->name('staff.edit');
    Route::put('/staff-management/{id}', [UserController::class, 'update'])->name('staff.update');
    Route::delete('/staff-management/{id}', [UserController::class, 'delete'])->name('staff.delete');
    Route::post('/staff-management/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('staff.toggleStatus');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/leaves', [LeaveController::class, 'index'])->name('leaves.index');
    Route::get('/leaves/create', [LeaveController::class, 'create'])->name('leaves.create');
    Route::post('/leaves', [LeaveController::class, 'store'])->name('leaves.store');
    Route::get('/leaves/{id}/edit', [LeaveController::class, 'edit'])->name('leaves.edit');
    Route::put('/leaves/{id}', [LeaveController::class, 'update'])->name('leaves.update');
    Route::delete('/leaves/{id}', [LeaveController::class, 'delete'])->name('leaves.delete');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/leave-management', [AdminLeaveController::class, 'index'])->name('admin.leaves.index');
    Route::post('/leave-management/{id}/validate', [AdminLeaveController::class, 'approve'])->name('admin.leaves.validate');
    Route::post('/leave-management/{id}/reject', [AdminLeaveController::class, 'reject'])->name('admin.leaves.reject');
});





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




require __DIR__.'/auth.php';
