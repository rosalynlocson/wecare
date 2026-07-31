<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');

        $patients = Patient::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('first_name', 'ilike', "%{$search}%")
                        ->orWhere('last_name', 'ilike', "%{$search}%")
                        ->orWhere('contact_number', 'ilike', "%{$search}%");

                    if (is_numeric($search)) {
                        $q->orWhere('id', $search);
                    }
                });
            })
            ->orderBy('last_name')
            ->paginate(15);

        return view('patients.index', compact('patients', 'search'));
    }
    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateData($request);

        $patient = Patient::create($validated);

        return redirect()->route('patients.show', $patient)->with('status', 'Patient registered successfully.');
    }

    public function show(Patient $patient)
    {
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $validated = $this->validateData($request);

        $patient->update($validated);

        return redirect()->route('patients.show', $patient)->with('status', 'Patient updated successfully.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            'contact_number' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'gender' => 'required|string|max:20',
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_relationship' => 'required|string|max:100',
            'emergency_contact_number' => 'required|string|max:20',
        ]);
    }
}