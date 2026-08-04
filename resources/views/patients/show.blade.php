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

            <div class="bg-white p-6 shadow sm:rounded-lg mt-6">
                <p class="text-sm font-medium text-gray-600 mb-3">Visit History</p>

                @forelse ($records as $record)
                    <div class="border rounded-md p-3 mb-3">
                        <div class="flex justify-between">
                            <p class="text-sm font-medium">{{ $record->appointment->appointment_date->format('M j, Y') }} &middot; {{ $record->appointment->treatmentType->name }}</p>
                            <p class="text-xs text-gray-400">{{ $record->appointment->doctor->name }}</p>
                        </div>
                        <p class="text-sm text-gray-600 my-2">{{ $record->notes }}</p>

                        @if ($record->attachments->count())
                            <div class="flex gap-2 flex-wrap mt-2">
                                @foreach ($record->attachments as $attachment)
                                    <a href="{{ Storage::disk('attachments')->temporaryUrl($attachment->file_path, now()->addMinutes(30)) }}" target="_blank" class="text-xs bg-gray-50 text-gray-600 px-2 py-1 rounded-md">
                                        📄 {{ $attachment->original_name }}
                                    </a>
                                @endforeach
                            </div>
                        @endif

                        <p class="text-xs text-gray-400 mt-2">
                            Created by {{ $record->createdBy->name }}, {{ $record->created_at->format('M j, Y g:i A') }}
                            @if ($record->updatedBy)
                                &middot; Last updated by {{ $record->updatedBy->name }}, {{ $record->updated_at->format('M j, Y g:i A') }}
                            @endif
                        </p>

                        @if (auth()->user()->isDoctor() && $record->appointment->doctor_id === auth()->id())
                            <div class="mt-2 flex gap-3">
                                <a href="{{ route('records.edit', $record) }}" class="text-blue-600 text-xs">Edit</a>
                                <form method="POST" action="{{ route('records.archive', $record) }}" onsubmit="return confirm('Archive this record?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="text-gray-500 text-xs">Archive</button>
                                </form>
                            </div>
                        @endif
                    </div>
                @empty
                    <p class="text-sm text-gray-400">No medical records yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>