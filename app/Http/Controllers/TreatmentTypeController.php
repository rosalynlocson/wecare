<?php

namespace App\Http\Controllers;

use App\Models\TreatmentType;
use Illuminate\Http\Request;

class TreatmentTypeController extends Controller
{
    public function index()
    {
        $treatmentTypes = TreatmentType::orderBy('name')->get();

        return view('treatment-types.index', compact('treatmentTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'default_price' => 'required|numeric|min:0',
        ]);

        TreatmentType::create($validated);

        return redirect()->route('treatment-types.index')->with('status', 'Treatment type added successfully.');
    }

    public function update(Request $request, TreatmentType $treatmentType)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'default_price' => 'required|numeric|min:0',
        ]);

        $treatmentType->update($validated);

        return redirect()->route('treatment-types.index')->with('status', 'Treatment type updated successfully.');
    }
}