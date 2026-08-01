<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Cancel Appointment</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <p class="text-sm text-gray-600 mb-4">
                    Cancelling appointment for <strong>{{ $appointment->patient->fullName() }}</strong>
                    with {{ $appointment->doctor->name }} on {{ $appointment->appointment_date->format('M j, Y') }}
                    at {{ $appointment->appointment_time->format('g:i A') }}.
                </p>

                <form method="POST" action="{{ route('appointments.destroy', $appointment) }}">
                    @csrf
                    @method('DELETE')

                    <label class="block text-sm text-gray-600">Reason for cancellation</label>
                    <textarea name="cancellation_note" class="mt-1 block w-full rounded-md border-gray-300" rows="3" placeholder="e.g. Patient requested reschedule">{{ old('cancellation_note') }}</textarea>
                    @error('cancellation_note') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('appointments.index') }}" class="px-4 py-2 border rounded-md text-sm text-gray-600">Back</a>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-md text-sm">Confirm Cancellation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>