<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function store(Appointment $appointment)
    {
        if ($appointment->invoice) {
            return redirect()->route('appointments.index')->with('status', 'An invoice already exists for this appointment.');
        }

        $invoice = Invoice::create([
            'appointment_id' => $appointment->id,
            'amount' => $appointment->treatmentType->default_price,
            'status' => 'unpaid',
            'generated_by' => auth()->id(),
        ]);

        return redirect()->route('invoices.show', $invoice)->with('status', 'Invoice generated successfully.');
    }

    public function show(Invoice $invoice)
    {
        return view('invoices.show', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $validated = $request->validate([
            'status' => 'required|in:paid,unpaid',
        ]);

        $invoice->update($validated);

        return redirect()->route('invoices.show', $invoice)->with('status', 'Invoice status updated.');
    }

    public function print(Invoice $invoice)
    {
        return view('invoices.print', compact('invoice'));
    }
}