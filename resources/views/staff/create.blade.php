<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add Staff Account</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-lg mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('staff.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Full Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('name') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('email') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Role</label>
                        <select name="role" class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="">Select role</option>
                            <option value="doctor" @selected(old('role') == 'doctor')>Doctor</option>
                            <option value="receptionist" @selected(old('role') == 'receptionist')>Receptionist</option>
                        </select>
                        @error('role') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Password</label>
                        <input type="password" name="password" class="mt-1 block w-full rounded-md border-gray-300">
                        @error('password') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm text-gray-600">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300">
                    </div>

                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('staff.index') }}" class="px-4 py-2 border rounded-md text-sm text-gray-600">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">Create Account</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>