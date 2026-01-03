<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ModuleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
    
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('modules', ModuleController::class);

    // Teacher routes
    Route::prefix('teacher')->name('teacher.')->group(function () {
        Route::get('modules', [App\Http\Controllers\Teacher\ModuleController::class, 'index'])->name('modules.index');
        Route::get('modules/{module}', [App\Http\Controllers\Teacher\ModuleController::class, 'show'])->name('modules.show');
        Route::post('modules/{module}/enrolments/{enrolment}/grade', [App\Http\Controllers\Teacher\ModuleController::class, 'grade'])->name('modules.enrolments.grade');
    });

    // Student dashboard
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('dashboard', [App\Http\Controllers\Student\DashboardController::class, 'index'])->name('dashboard');
    });

        // Student enrolments
        Route::post('modules/{module}/enrol', [App\Http\Controllers\EnrolmentController::class, 'store'])->name('modules.enrol');
    // Admin users management
    Route::get('admin/users', [App\Http\Controllers\Admin\UserRoleController::class, 'index'])->name('admin.users.index');
    Route::patch('admin/users/{user}', [App\Http\Controllers\Admin\UserRoleController::class, 'update'])->name('admin.users.update');
    Route::post('admin/users', [App\Http\Controllers\Admin\UserRoleController::class, 'store'])->name('admin.users.store');
    Route::delete('admin/users/{user}', [App\Http\Controllers\Admin\UserRoleController::class, 'destroy'])->name('admin.users.destroy');

    // Admin module teacher assignment
    Route::get('admin/modules/{module}/teacher', [App\Http\Controllers\Admin\ModuleTeacherController::class, 'edit'])->name('admin.modules.teacher.edit');
    Route::patch('admin/modules/{module}/teacher', [App\Http\Controllers\Admin\ModuleTeacherController::class, 'update'])->name('admin.modules.teacher.update');

    // Admin modules index
    Route::get('admin/modules', [App\Http\Controllers\Admin\ModuleAdminController::class, 'index'])->name('admin.modules.index');

    // Admin module show & student removal
    Route::get('admin/modules/{module}', [App\Http\Controllers\Admin\ModuleAdminController::class, 'show'])->name('admin.modules.show');
    Route::delete('admin/modules/{module}/students/{enrolment}', [App\Http\Controllers\Admin\ModuleAdminController::class, 'removeStudent'])->name('admin.modules.students.destroy');
});

require __DIR__.'/auth.php';
