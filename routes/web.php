<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\frontend\HomeController::class, 'index'])->name('home');
Route::get('/appointment', [App\Http\Controllers\auth\AppointmentController::class, 'index'])->name('appointment');
Route::post('/appointment/store', [App\Http\Controllers\auth\AppointmentController::class, 'store'])->name('appointment.store');
Route::get('/login', [App\Http\Controllers\auth\LoginController::class, 'index'])->name('login');
Route::post('/login/auth', [App\Http\Controllers\auth\LoginController::class, 'login'])->name('login.auth');
Route::get('/logout', [App\Http\Controllers\auth\LoginController::class, 'logout'])->name('logout');

//User Dashboard
Route::middleware(['auth', 'patient'])->prefix('patient')->group(function () {
Route::get('/dashboard', [App\Http\Controllers\user\DashboardController::class, 'index'])->name('patient.dashboard');
Route::get('/appointment', [App\Http\Controllers\user\AppointmentController::class, 'index'])->name('patient.appointment');
Route::get('/book_appointment', [App\Http\Controllers\user\AppointmentController::class, 'book_appointment'])->name('patient.book_appointment');
Route::post('/book_appointment/store', [App\Http\Controllers\user\AppointmentController::class, 'save_Appointment'])->name('patient.book_appointment.store');
Route::post('/generate-token', [App\Http\Controllers\API\GenerateAccessTokenController::class, 'generate_token']);
});