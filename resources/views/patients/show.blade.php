<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Patient Record</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">{{ session('status') }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-lg font-medium">{{ $patient->fullName() }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $patient->date_of_birth->format('M j, Y') }} &middot;
                            {{ ucfirst($patient->gender) }} &middot;
                            Patient ID #{{ $patient->id }}
                        </p>
                    </div>
                    @if (auth()->user()->isReceptionist())
                        <a href="{{ route('patients.edit', $patient) }}" class="px-3 py-1.5 border rounded-md text-sm">Edit</a>
                    @endif
                </div>

                <div class="grid grid-cols-2 gap-4 text-sm border-t pt-4">
                    <div><span class="text-gray-500">Contact:</span> {{ $patient->contact_number }}</div>
                    <div><span class="text-gray-500">Email:</span> {{ $patient->email ?? '—' }}</div>
                    <div class="col-span-2"><span class="text-gray-500">Address:</span> {{ $patient->address }}</div>
                    <div class="col-span-2 border-t pt-3 mt-1">
                        <span class="text-gray-500">Emergency Contact:</span>
                        {{ $patient->emergency_contact_name }} ({{ $patient->emergency_contact_relationship }}) — {{ $patient->emergency_contact_number }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>