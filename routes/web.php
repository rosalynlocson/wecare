<?php

use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreatmentTypeController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\DashboardController;


Route::get('/', function () {
    return view('welcome');
});


Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

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

Route::middleware(['auth', 'role:receptionist,doctor'])->group(function () {
    Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');
});

Route::middleware(['auth', 'role:receptionist'])->group(function () {
    Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');
    Route::post('/appointments', [AppointmentController::class, 'store'])->name('appointments.store');
    Route::get('/appointments/{appointment}/edit', [AppointmentController::class, 'edit'])->name('appointments.edit');
    Route::put('/appointments/{appointment}', [AppointmentController::class, 'update'])->name('appointments.update');
    Route::delete('/appointments/{appointment}', [AppointmentController::class, 'destroy'])->name('appointments.destroy');
    Route::get('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancelForm'])->name('appointments.cancelForm');
    Route::patch('/appointments/{appointment}/arrive', [AppointmentController::class, 'markArrived'])->name('appointments.arrive');
});

Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/appointments/{appointment}/records/create', [MedicalRecordController::class, 'create'])->name('records.create');
    Route::post('/appointments/{appointment}/records', [MedicalRecordController::class, 'store'])->name('records.store');
    Route::get('/records/{record}/edit', [MedicalRecordController::class, 'edit'])->name('records.edit');
    Route::put('/records/{record}', [MedicalRecordController::class, 'update'])->name('records.update');
    Route::patch('/records/{record}/archive', [MedicalRecordController::class, 'archive'])->name('records.archive');
    Route::delete('/attachments/{attachment}', [AttachmentController::class, 'destroy'])->name('attachments.destroy');
});

Route::middleware(['auth', 'role:receptionist'])->group(function () {
    Route::post('/appointments/{appointment}/invoice', [InvoiceController::class, 'store'])->name('invoices.store');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::patch('/invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus');
    Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
});


require __DIR__ . '/auth.php';