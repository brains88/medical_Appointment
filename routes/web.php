<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [App\Http\Controllers\frontend\HomeController::class, 'index'])->name('home');
Route::get('/appointment', [App\Http\Controllers\auth\AppointmentController::class, 'index'])->name('appointment');
Route::post('/appointment/store', [App\Http\Controllers\auth\AppointmentController::class, 'store'])->name('appointment.store');
Route::get('/login', [App\Http\Controllers\auth\LoginController::class, 'index'])->name('login');
Route::post('/login/auth', [App\Http\Controllers\auth\LoginController::class, 'login'])->name('login.auth');
Route::get('/logout', [App\Http\Controllers\auth\LoginController::class, 'logout'])->name('logout');
Route::get('/check-doctor-availability', [App\Http\Controllers\auth\AppointmentController::class, 'checkAvailability'])
    ->name('check.doctor.availability');
//User Dashboard
Route::middleware(['auth', 'patient'])->prefix('patient')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\user\DashboardController::class, 'index'])->name('patient.dashboard');
    Route::get('/appointment', [App\Http\Controllers\user\AppointmentController::class, 'index'])->name('patient.appointment');
    Route::get('/book_appointment', [App\Http\Controllers\user\AppointmentController::class, 'book_appointment'])->name('patient.book_appointment');
    Route::post('/book_appointment/store', [App\Http\Controllers\user\AppointmentController::class, 'save_Appointment'])->name('patient.book_appointment.store');
    Route::post('/generate-token', [App\Http\Controllers\API\GenerateAccessTokenController::class, 'generate_token']);
});

Route::middleware(['auth', 'doctor'])->prefix('doctor')->name('doctor.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\doctor\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/appointment', [App\Http\Controllers\doctor\AppointmentController::class, 'index'])->name('appointment');
    Route::put('/appointments/{appointment}/status', [App\Http\Controllers\doctor\AppointmentController::class, 'updateStatus'])->name('update.status');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard - Now correctly named 'admin.dashboard'
    Route::get('/dashboard', [App\Http\Controllers\admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Doctors Routes - All names will be prefixed with 'admin.doctors.'
    Route::prefix('doctors')->name('doctors.')->group(function () {
        Route::get('/', [App\Http\Controllers\admin\DoctorController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\admin\DoctorController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\admin\DoctorController::class, 'store'])->name('store');
        Route::get('/{doctor}', [App\Http\Controllers\admin\DoctorController::class, 'show'])->name('show');
        Route::get('/{doctor}/edit', [App\Http\Controllers\admin\DoctorController::class, 'edit'])->name('edit');
        Route::put('/{doctor}', [App\Http\Controllers\admin\DoctorController::class, 'update'])->name('update');
        Route::delete('/{doctor}', [App\Http\Controllers\admin\DoctorController::class, 'destroy'])->name('destroy');
        
        // Add the stats route while maintaining your structure
        Route::get('/{doctor}/stats', [App\Http\Controllers\admin\DoctorController::class, 'getDoctorStats'])
            ->name('stats');
       //delete Doctors
       Route::delete('{doctor}/delete', [App\Http\Controllers\admin\DoctorController::class, 'deleteDoctor'])
       ->name('delete');
        });

    // Patients Routes - All names will be prefixed with 'admin.patients.'
    Route::prefix('patients')->name('patients.')->group(function () {
        Route::get('/', [App\Http\Controllers\admin\PatientController::class, 'index'])->name('index');
        Route::get('/{patient}', [App\Http\Controllers\admin\PatientController::class, 'show'])->name('show');
        Route::get('/{patient}/stats', [App\Http\Controllers\admin\PatientController::class, 'getAppointmentStats'])->name('stats'); // New route
       //delete Patient
       Route::delete('{patient}/delete', [App\Http\Controllers\admin\PatientController::class, 'deletePatient'])
       ->name('delete');
  
    });
    // Appointments Routes - All names will be prefixed with 'admin.appointments.'
    Route::prefix('appointments')->name('appointments.')->group(function () {
        Route::get('/', [App\Http\Controllers\admin\AppointmentController::class, 'index'])->name('index');
        Route::get('/pending', [App\Http\Controllers\admin\AppointmentController::class, 'pending'])->name('pending');
        Route::get('/{appointment}', [App\Http\Controllers\admin\AppointmentController::class, 'show'])->name('show');
        Route::put('/{appointment}/status', [App\Http\Controllers\admin\AppointmentController::class, 'updateStatus'])->name('update.status');
        Route::delete('/{appointment}', [App\Http\Controllers\admin\AppointmentController::class, 'destroy'])->name('destroy');
        Route::get('/{appointment}/message', [App\Http\Controllers\admin\AppointmentController::class, 'showMessage'])->name('message');
    });
    
});