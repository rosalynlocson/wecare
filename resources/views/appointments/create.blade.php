<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">New Appointment</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('appointments.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Patient</label>
                        <select name="patient_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Select patient</option>
                            @foreach ($patients as $patient)
                                <option value="{{ $patient->id }}" @selected(old('patient_id') == $patient->id)>{{ $patient->fullName() }}</option>
                            @endforeach
                        </select>
                        @error('patient_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Treatment Type</label>
                        <select name="treatment_type_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Select treatment</option>
                            @foreach ($treatmentTypes as $type)
                                <option value="{{ $type->id }}" @selected(old('treatment_type_id') == $type->id)>{{ $type->name }} (₱{{ $type->default_price }})</option>
                            @endforeach
                        </select>
                        @error('treatment_type_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Doctor</label>
                        <select name="doctor_id" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Select doctor</option>
                            @foreach ($doctors as $doctor)
                                <option value="{{ $doctor->id }}" @selected(old('doctor_id') == $doctor->id)>{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm text-gray-600">Date</label>
                            <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" class="mt-1 block w-full rounded-md border-gray-300">
                            @error('appointment_date') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Time</label>
                            <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" class="mt-1 block w-full rounded-md border-gray-300">
                            @error('appointment_time') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Notes</label>
                        <textarea name="notes" class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes') }}</textarea>
                    </div>

                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('appointments.index') }}" class="px-4 py-2 border rounded-md text-sm text-gray-600">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">Book Appointment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>