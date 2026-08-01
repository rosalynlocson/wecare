<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreatmentTypeController;

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
});

Route::middleware(['auth', 'role:receptionist'])->group(function () {
    Route::get('/patients/create', [PatientController::class, 'create'])->name('patients.create');
    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');
    Route::get('/patients/{patient}/edit', [PatientController::class, 'edit'])->name('patients.edit');
    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');
});

Route::middleware(['auth', 'role:receptionist,doctor,admin'])->group(function () {
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/create', [StaffController::class, 'create'])->name('staff.create');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');
    Route::patch('/staff/{user}/deactivate', [StaffController::class, 'deactivate'])->name('staff.deactivate');
    Route::patch('/staff/{user}/activate', [StaffController::class, 'activate'])->name('staff.activate');
});

Route::middleware(['auth', 'role:admin,doctor'])->group(function () {
    Route::get('/doctors/{doctor}/availability', [AvailabilityController::class, 'edit'])->name('availability.edit');
    Route::put('/doctors/{doctor}/availability', [AvailabilityController::class, 'update'])->name('availability.update');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/treatment-types', [TreatmentTypeController::class, 'index'])->name('treatment-types.index');
    Route::post('/treatment-types', [TreatmentTypeController::class, 'store'])->name('treatment-types.store');
    Route::put('/treatment-types/{treatmentType}', [TreatmentTypeController::class, 'update'])->name('treatment-types.update');
});

require __DIR__ . '/auth.php';