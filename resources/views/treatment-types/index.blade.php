<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Treatment Types</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">{{ session('status') }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg mb-6">
                <p class="text-sm font-medium text-gray-600 mb-3">Add Treatment Type</p>
                <form method="POST" action="{{ route('treatment-types.store') }}" class="flex gap-2">
                    @csrf
                    <input type="text" name="name" placeholder="e.g. Consultation" class="flex-1 rounded-md border-gray-300 text-sm" value="{{ old('name') }}">
                    <input type="number" step="0.01" name="default_price" placeholder="Price" class="w-32 rounded-md border-gray-300 text-sm" value="{{ old('default_price') }}">
                    <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">Add</button>
                </form>
                @error('name') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
                @error('default_price') <p class="text-sm text-red-600 mt-2">{{ $message }}</p> @enderror
            </div>

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <table class="w-full text-sm text-left">
                    <thead>
                        <tr class="text-gray-500 border-b">
                            <th class="py-2">Name</th>
                            <th class="py-2">Default Price</th>
                            <th class="py-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($treatmentTypes as $type)
                            <tr class="border-b">
                                <form method="POST" action="{{ route('treatment-types.update', $type) }}">
                                    @csrf @method('PUT')
                                    <td class="py-2"><input type="text" name="name" value="{{ $type->name }}" class="rounded-md border-gray-300 text-sm w-full"></td>
                                    <td class="py-2"><input type="number" step="0.01" name="default_price" value="{{ $type->default_price }}" class="rounded-md border-gray-300 text-sm w-28"></td>
                                    <td class="py-2 text-right"><button type="submit" class="text-blue-600 text-sm">Save</button></td>
                                </form>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-6 text-center text-gray-400">No treatment types yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>