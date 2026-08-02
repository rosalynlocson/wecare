<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Appointments</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">{{ session('status') }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <form method="GET" class="flex items-center gap-2">
                        <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()"
                            class="rounded-md border-gray-300 text-sm">
                    </form>
                    @if (auth()->user()->isReceptionist())
                        <a href="{{ route('appointments.create') }}"
                            class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">+ New Appointment</a>
                    @endif
                </div>

                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-500 border-b">
                            <th class="py-2">Time</th>
                            <th class="py-2">Patient</th>
                            <th class="py-2">Doctor</th>
                            <th class="py-2">Treatment</th>
                            <th class="py-2">Status</th>
                            <th class="py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appt)
                            <tr class="border-b">
                                <td class="py-2">{{ $appt->appointment_time->format('g:i A') }}</td>
                                <td class="py-2">{{ $appt->patient->fullName() }}</td>
                                <td class="py-2">{{ $appt->doctor->name }}</td>
                                <td class="py-2">{{ $appt->treatmentType->name }}</td>
                                <td class="py-2">
                                    @if ($appt->status === 'arrived')
                                        <span class="text-green-700 bg-green-50 text-xs px-2 py-0.5 rounded-md">Arrived</span>
                                    @elseif ($appt->status === 'cancelled')
                                        <span class="text-red-700 bg-red-50 text-xs px-2 py-0.5 rounded-md">Cancelled</span>
                                    @else
                                        <span class="text-gray-500 bg-gray-100 text-xs px-2 py-0.5 rounded-md">Scheduled</span>
                                    @endif
                                </td>
                                <td class="py-2 text-right whitespace-nowrap">
                                    @if (auth()->user()->isReceptionist() && $appt->status === 'scheduled')
                                        <form method="POST" action="{{ route('appointments.arrive', $appt) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-green-600 text-xs mr-2">Mark Arrived</button>
                                        </form>
                                        <a href="{{ route('appointments.edit', $appt) }}"
                                            class="text-blue-600 text-xs mr-2">Edit</a>
                                        <a href="{{ route('appointments.cancelForm', $appt) }}"
                                            class="text-red-600 text-xs">Cancel</a>
                                    @endif
                                    @if (auth()->user()->isReceptionist() && $appt->status === 'arrived')
                                        @if ($appt->invoice)
                                            <a href="{{ route('invoices.show', $appt->invoice) }}" class="text-blue-600 text-xs">View Invoice</a>
                                        @else
                                            <form method="POST" action="{{ route('invoices.store', $appt) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-green-600 text-xs">Generate Invoice</button>
                                            </form>
                                        @endif
                                    @endif
                                    @if ($appt->status === 'cancelled')
                                        <details class="inline-block text-left">
                                            <summary class="text-gray-500 text-xs cursor-pointer list-none inline">View Note</summary>
                                            <div class="text-xs text-gray-600 bg-gray-50 border rounded-md p-2 mt-1 max-w-xs">
                                                {{ $appt->cancellation_note }}
                                            </div>
                                        </details>
                                    @endif
                                    @if (auth()->user()->isDoctor() && $appt->doctor_id === auth()->id())
                                        <a href="{{ route('records.create', $appt) }}" class="text-blue-600 text-xs">Add Record</a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-gray-400">No appointments for this date.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>