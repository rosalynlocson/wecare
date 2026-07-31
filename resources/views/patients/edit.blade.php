<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Patient</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('patients.update', $patient) }}">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm text-gray-600">First Name</label>
                            <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('first_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Middle Name</label>
                            <input type="text" name="middle_name" value="{{ old('middle_name', $patient->middle_name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Last Name</label>
                            <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('last_name')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm text-gray-600">Date of Birth</label>
                            <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('date_of_birth')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Sex/Gender</label>
                            <select name="gender" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">Select</option>
                                <option value="male" @selected(old('gender', $patient->gender) == 'male')>Male</option>
                                <option value="female" @selected(old('gender', $patient->gender) == 'female')>Female</option>
                            </select>
                            @error('gender')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm text-gray-600">Contact Number</label>
                            <input type="text" name="contact_number" value="{{ old('contact_number', $patient->contact_number) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('contact_number')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm text-gray-600">Email</label>
                            <input type="email" name="email" value="{{ old('email', $patient->email) }}"
                                class="mt-1 block w-full rounded-md border-gray-300">
                            @error('email')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="mt-4">
                        <label class="block text-sm text-gray-600">Address</label>
                        <input type="text" name="address" value="{{ old('address', $patient->address) }}"
                            class="mt-1 block w-full rounded-md border-gray-300">
                        @error('address')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-6 pt-4 border-t">
                        <p class="text-sm font-medium text-gray-600 mb-2">Emergency Contact</p>
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <input type="text" name="emergency_contact_name" placeholder="Name"
                                    value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}"
                                    class="block w-full rounded-md border-gray-300">
                                @error('emergency_contact_name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <input type="text" name="emergency_contact_relationship" placeholder="Relationship"
                                    value="{{ old('emergency_contact_relationship', $patient->emergency_contact_relationship) }}"
                                    class="block w-full rounded-md border-gray-300">
                                @error('emergency_contact_relationship')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <input type="text" name="emergency_contact_number" placeholder="Contact Number"
                                    value="{{ old('emergency_contact_number', $patient->emergency_contact_number) }}"
                                    class="block w-full rounded-md border-gray-300">
                                @error('emergency_contact_number')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('patients.index') }}"
                            class="px-4 py-2 border rounded-md text-sm text-gray-600">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">Update
                            Patient</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>