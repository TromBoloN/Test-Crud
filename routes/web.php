<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\RegisterController;

// Add these routes
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('/', function () {
    return view('auth.login');
})->name('home');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::middleware(['role:teacher'])->group(function () {
        Route::get('/teacher/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
        Route::get('/teacher/create-assignment', [TeacherController::class, 'createAssignment'])->name('teacher.create-assignment');
        Route::post('/teacher/store-assignment', [TeacherController::class, 'storeAssignment'])->name('teacher.store-assignment');
        Route::patch('/teacher/grade-submission/{submission}', [TeacherController::class, 'gradeSubmission'])->name('teacher.grade-submission');
        Route::get('/teacher/submission/{submission}', [TeacherController::class, 'viewSubmission'])->name('teacher.view-submission');
        Route::get('/teacher/submission/{submission}/download', [TeacherController::class, 'downloadSubmission'])->name('teacher.download-submission');
    });

    Route::middleware(['role:student'])->group(function () {
        Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::post('/student/submit-assignment/{assignment}', [StudentController::class, 'submitAssignment'])->name('student.submit-assignment');
    });
});

Route::get('/test', function () {
    return view('test');
});
Route::post('/test', function () {
    return 'Test post route reached';
});

Route::get('/test-s3', [TeacherController::class, 'testS3']);
