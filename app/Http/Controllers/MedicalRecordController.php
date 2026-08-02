<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicalRecordController extends Controller
{
    public function create(Appointment $appointment)
    {
        $this->authorizeDoctor($appointment->doctor_id);

        return view('medical-records.create', compact('appointment'));
    }

    public function store(Request $request, Appointment $appointment)
    {
        $this->authorizeDoctor($appointment->doctor_id);

        $validated = $request->validate([
            'notes' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240', // 10MB per file
        ]);

        $record = MedicalRecord::create([
            'patient_id' => $appointment->patient_id,
            'appointment_id' => $appointment->id,
            'created_by' => auth()->id(),
            'notes' => $validated['notes'],
        ]);

        $this->storeAttachments($request, $record);

        return redirect()->route('patients.show', $appointment->patient_id)
            ->with('status', 'Medical record added successfully.');
    }

    public function edit(MedicalRecord $record)
    {
        $this->authorizeDoctor($record->appointment->doctor_id);

        return view('medical-records.edit', compact('record'));
    }

    public function update(Request $request, MedicalRecord $record)
    {
        $this->authorizeDoctor($record->appointment->doctor_id);

        $validated = $request->validate([
            'notes' => 'required|string',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        $record->update([
            'notes' => $validated['notes'],
            'updated_by' => auth()->id(),
        ]);

        $this->storeAttachments($request, $record);

        return redirect()->route('patients.show', $record->patient_id)
            ->with('status', 'Medical record updated successfully.');
    }

    public function archive(MedicalRecord $record)
    {
        $this->authorizeDoctor($record->appointment->doctor_id);

        $record->update(['archived' => true, 'updated_by' => auth()->id()]);

        return redirect()->route('patients.show', $record->patient_id)
            ->with('status', 'Medical record archived.');
    }

    private function storeAttachments(Request $request, MedicalRecord $record): void
    {
        if (! $request->hasFile('attachments')) {
            return;
        }

        foreach ($request->file('attachments') as $file) {
            $path = $file->store('medical-records', 'public');

            $record->attachments()->create([
                'file_path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'uploaded_by' => auth()->id(),
            ]);
        }
    }

    /**
     * FR-9 / Role table: only the assigned doctor may create/edit/archive a record.
     * Admin has view-only access (via the patient show page), not edit access.
     */
    private function authorizeDoctor(int $doctorId): void
    {
        $user = auth()->user();

        if ($user->id !== $doctorId) {
            abort(403);
        }
    }
}