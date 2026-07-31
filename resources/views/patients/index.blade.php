<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Patients</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">{{ session('status') }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <div class="flex justify-between mb-4">
                    <form method="GET" class="flex-1 max-w-sm">
                        <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, contact, or ID..." class="w-full rounded-md border-gray-300 text-sm">
                    </form>
                    @auth
                        @if (auth()->user()->isReceptionist())
                            <a href="{{ route('patients.create') }}" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">+ Register Patient</a>
                        @endif
                    @endauth
                </div>

                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-500 border-b">
                            <th class="py-2">Name</th>
                            <th class="py-2">Date of Birth</th>
                            <th class="py-2">Contact</th>
                            <th class="py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($patients as $patient)
                            <tr class="border-b">
                                <td class="py-2">{{ $patient->fullName() }}</td>
                                <td class="py-2">{{ $patient->date_of_birth->format('M j, Y') }}</td>
                                <td class="py-2">{{ $patient->contact_number }}</td>
                                <td class="py-2 text-right">
                                    <a href="{{ route('patients.show', $patient) }}" class="text-blue-600">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="py-6 text-center text-gray-400">No patients found.</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">{{ $patients->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>