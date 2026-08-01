<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\TreatmentType;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $date = $request->query('date', now()->toDateString());

        $query = Appointment::with(['patient', 'doctor', 'treatmentType'])
            ->whereDate('appointment_date', $date)
            ->orderBy('appointment_time');

        // Doctors only see their own day's appointments (FR-3)
        if ($user->isDoctor()) {
            $query->where('doctor_id', $user->id);
        }

        $appointments = $query->get();

        return view('appointments.index', compact('appointments', 'date'));
    }

    public function create()
    {
        $patients = Patient::orderBy('last_name')->get();
        $doctors = User::where('role', 'doctor')->where('is_active', true)->orderBy('name')->get();
        $treatmentTypes = TreatmentType::orderBy('name')->get();

        return view('appointments.create', compact('patients', 'doctors', 'treatmentTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'treatment_type_id' => 'required|exists:treatment_types,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ]);

        $this->ensureNoConflict($validated);

        Appointment::create([
            ...$validated,
            'booked_by' => auth()->id(),
            'status' => 'scheduled',
        ]);

        return redirect()->route('appointments.index')->with('status', 'Appointment booked successfully.');
    }

    public function edit(Appointment $appointment)
    {
        $patients = Patient::orderBy('last_name')->get();
        $doctors = User::where('role', 'doctor')->where('is_active', true)->orderBy('name')->get();
        $treatmentTypes = TreatmentType::orderBy('name')->get();

        return view('appointments.edit', compact('appointment', 'patients', 'doctors', 'treatmentTypes'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'treatment_type_id' => 'required|exists:treatment_types,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required|date_format:H:i',
            'notes' => 'nullable|string',
        ]);

        $this->ensureNoConflict($validated, ignoreId: $appointment->id);

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('status', 'Appointment updated successfully.');
    }

    public function cancelForm(Appointment $appointment)
    {
        return view('appointments.cancel', compact('appointment'));
    }

    public function destroy(Request $request, Appointment $appointment)
    {
        $validated = $request->validate([
            'cancellation_note' => 'required|string|max:500',
        ]);

        $appointment->update([
            'status' => 'cancelled',
            'cancellation_note' => $validated['cancellation_note'],
        ]);

        return redirect()->route('appointments.index')->with('status', 'Appointment cancelled.');
    }

    public function markArrived(Appointment $appointment)
    {
        $appointment->update([
            'status' => 'arrived',
            'arrived_at' => now(),
        ]);

        return redirect()->back()->with('status', "{$appointment->patient->fullName()} marked as arrived.");
    }

    /**
     * FR-4: Prevent double-booking a doctor for overlapping times.
     * Simple version: no two active appointments for the same doctor at the same date+time.
     */
    private function ensureNoConflict(array $data, ?int $ignoreId = null): void
    {
        $conflict = Appointment::where('doctor_id', $data['doctor_id'])
            ->where('appointment_date', $data['appointment_date'])
            ->where('appointment_time', $data['appointment_time'])
            ->where('status', '!=', 'cancelled')
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists();

        if ($conflict) {
            throw ValidationException::withMessages([
                'appointment_time' => 'This doctor already has an appointment at that date and time.',
            ]);
        }
    }
}