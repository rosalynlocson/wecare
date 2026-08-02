<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Medical Record</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <p class="text-sm text-gray-600 mb-4">
                    For <strong>{{ $appointment->patient->fullName() }}</strong> —
                    {{ $appointment->appointment_date->format('M j, Y') }} &middot; {{ $appointment->treatmentType->name }}
                </p>

                <form method="POST" action="{{ route('records.store', $appointment) }}" enctype="multipart/form-data">
                    @csrf

                    <label class="block text-sm text-gray-600">Notes</label>
                    <textarea name="notes" rows="6" class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes') }}</textarea>
                    @error('notes') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

                    <label class="block text-sm text-gray-600 mt-4">Attachments (optional)</label>
                    <input type="file" name="attachments[]" multiple class="mt-1 block w-full text-sm">
                    @error('attachments.*') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('appointments.index') }}" class="px-4 py-2 border rounded-md text-sm text-gray-600">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">Save Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>