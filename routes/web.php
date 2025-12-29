<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ClassController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\Admin\AdminTeacherController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminRegistrationController;

// Landing Page
Route::get('/', function () {
    return redirect('/dashboard');
});

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes (perlu login)
Route::middleware('auth')->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Mata Pelajaran Routes
    Route::prefix('mata-pelajaran')->name('subjects.')->group(function () {
        Route::get('/', [SubjectController::class, 'index'])->name('index');
        Route::get('/{id}', [SubjectController::class, 'show'])->name('show');
    });

    // Jadwal Routes
    Route::prefix('jadwal')->name('schedules.')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('index');
        Route::get('/kelas/{classId}', [ScheduleController::class, 'byClass'])->name('by-class');
        Route::get('/hari/{day}', [ScheduleController::class, 'byDay'])->name('by-day');
    });

    // Registrasi Routes
    Route::prefix('registrasi')->name('registrations.')->group(function () {
        Route::get('/', [RegistrationController::class, 'index'])->name('index');
        Route::post('/daftar', [RegistrationController::class, 'register'])->name('register');
        Route::get('/saya', [RegistrationController::class, 'myRegistrations'])->name('my');
        Route::delete('/{id}', [RegistrationController::class, 'cancel'])->name('cancel');
    });

    // Kelas Routes
    Route::prefix('kelas')->name('classes.')->group(function () {
        Route::get('/', [ClassController::class, 'index'])->name('index');
        Route::get('/{id}', [ClassController::class, 'show'])->name('show');
        Route::get('/{id}/siswa', [ClassController::class, 'students'])->name('students');
    });
    
});

// Admin Routes (perlu login + admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Admin Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Admin Subjects Management
    Route::prefix('subjects')->name('subjects.')->group(function () {
        Route::get('/', [AdminSubjectController::class, 'index'])->name('index');
        Route::get('/create', [AdminSubjectController::class, 'create'])->name('create');
        Route::post('/', [AdminSubjectController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminSubjectController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminSubjectController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminSubjectController::class, 'destroy'])->name('destroy');
    });

    // Admin Teachers Management
    Route::prefix('teachers')->name('teachers.')->group(function () {
        Route::get('/', [AdminTeacherController::class, 'index'])->name('index');
        Route::get('/create', [AdminTeacherController::class, 'create'])->name('create');
        Route::post('/', [AdminTeacherController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminTeacherController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminTeacherController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminTeacherController::class, 'destroy'])->name('destroy');
    });

    // Admin Students Management
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', [AdminStudentController::class, 'index'])->name('index');
        Route::get('/create', [AdminStudentController::class, 'create'])->name('create');
        Route::post('/', [AdminStudentController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminStudentController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminStudentController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminStudentController::class, 'destroy'])->name('destroy');
    });

    // Admin Schedules Management
    Route::prefix('schedules')->name('schedules.')->group(function () {
        Route::get('/', [AdminScheduleController::class, 'index'])->name('index');
        Route::get('/create', [AdminScheduleController::class, 'create'])->name('create');
        Route::post('/', [AdminScheduleController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [AdminScheduleController::class, 'edit'])->name('edit');
        Route::put('/{id}', [AdminScheduleController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminScheduleController::class, 'destroy'])->name('destroy');
    });

    // Admin Registrations Management
    Route::prefix('registrations')->name('registrations.')->group(function () {
        Route::get('/', [AdminRegistrationController::class, 'index'])->name('index');
        Route::post('/{id}/approve', [AdminRegistrationController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminRegistrationController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [AdminRegistrationController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-approve', [AdminRegistrationController::class, 'bulkApprove'])->name('bulk-approve');
        Route::post('/bulk-reject', [AdminRegistrationController::class, 'bulkReject'])->name('bulk-reject');
    });
    
});