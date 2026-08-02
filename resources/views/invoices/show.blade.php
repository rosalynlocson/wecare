<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Invoice #{{ $invoice->id }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">{{ session('status') }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-sm text-gray-500">Patient</p>
                        <p class="font-medium">{{ $invoice->appointment->patient->fullName() }}</p>
                    </div>
                    @if ($invoice->status === 'paid')
                        <span class="text-green-700 bg-green-50 text-xs px-2 py-1 rounded-md">Paid</span>
                    @else
                        <span class="text-gray-500 bg-gray-100 text-xs px-2 py-1 rounded-md">Unpaid</span>
                    @endif
                </div>

                <div class="text-sm border-t pt-4 space-y-2">
                    <div class="flex justify-between"><span class="text-gray-500">Treatment</span><span>{{ $invoice->appointment->treatmentType->name }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Date</span><span>{{ $invoice->appointment->appointment_date->format('M j, Y') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Doctor</span><span>{{ $invoice->appointment->doctor->name }}</span></div>
                    <div class="flex justify-between font-medium text-base border-t pt-2 mt-2"><span>Amount</span><span>₱{{ number_format($invoice->amount, 2) }}</span></div>
                </div>

                <div class="mt-6 flex gap-2">
                    <a href="{{ route('invoices.print', $invoice) }}" target="_blank" class="px-4 py-2 border rounded-md text-sm text-gray-600">Print</a>
                    <form method="POST" action="{{ route('invoices.updateStatus', $invoice) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="{{ $invoice->status === 'paid' ? 'unpaid' : 'paid' }}">
                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">
                            Mark as {{ $invoice->status === 'paid' ? 'Unpaid' : 'Paid' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>