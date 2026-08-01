<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Staff</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">{{ session('status') }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <div class="flex justify-end mb-4">
                    <a href="{{ route('staff.create') }}" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">+ Add Staff</a>
                </div>

                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-500 border-b">
                            <th class="py-2">Name</th>
                            <th class="py-2">Email</th>
                            <th class="py-2">Role</th>
                            <th class="py-2">Status</th>
                            <th class="py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($staff as $member)
                            <tr class="border-b">
                                <td class="py-2">{{ $member->name }}</td>
                                <td class="py-2">{{ $member->email }}</td>
                                <td class="py-2 capitalize">{{ $member->role }}</td>
                                <td class="py-2">
                                    @if ($member->is_active)
                                        <span class="text-green-700 bg-green-50 text-xs px-2 py-0.5 rounded-md">Active</span>
                                    @else
                                        <span class="text-gray-500 bg-gray-100 text-xs px-2 py-0.5 rounded-md">Deactivated</span>
                                    @endif
                                </td>
                                <td class="py-2 text-right">
                                    @if ($member->is_active)
                                        <form method="POST" action="{{ route('staff.deactivate', $member) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-red-600">Deactivate</button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('staff.activate', $member) }}" class="inline">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="text-blue-600">Reactivate</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="py-6 text-center text-gray-400">No staff accounts yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>