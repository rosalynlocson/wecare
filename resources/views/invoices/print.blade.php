<!DOCTYPE html>
<html>
<head>
    <title>Invoice #{{ $invoice->id }}</title>
</head>
<body style="font-family: sans-serif; max-width: 500px; margin: 40px auto;">
    <h2>WeCare Clinic</h2>
    <p>Invoice #{{ $invoice->id }} &middot; {{ $invoice->created_at->format('M j, Y') }}</p>
    <hr>
    <p><strong>Patient:</strong> {{ $invoice->appointment->patient->fullName() }}</p>
    <p><strong>Doctor:</strong> {{ $invoice->appointment->doctor->name }}</p>
    <p><strong>Treatment:</strong> {{ $invoice->appointment->treatmentType->name }}</p>
    <p><strong>Date of Visit:</strong> {{ $invoice->appointment->appointment_date->format('M j, Y') }}</p>
    <hr>
    <h3>Total: ₱{{ number_format($invoice->amount, 2) }}</h3>
    <p><strong>Status:</strong> {{ ucfirst($invoice->status) }}</p>
    <script>window.print();</script>
</body>
</html>