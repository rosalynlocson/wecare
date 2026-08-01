<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $doctor->name }}'s Availability</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if (session('status'))
                <div class="mb-4 p-3 bg-green-50 text-green-700 text-sm rounded-md">{{ session('status') }}</div>
            @endif

            <div class="bg-white p-6 shadow sm:rounded-lg">
                <form method="POST" action="{{ route('availability.update', $doctor) }}">
                    @csrf
                    @method('PUT')

                    @foreach ($days as $day)
                        @php $existing = $availabilities->get($day); @endphp
                        <div class="flex items-center gap-4 py-2 border-b">
                            <label class="flex items-center gap-2 w-32">
                                <input type="checkbox" name="days[{{ $day }}][enabled]" value="1" @checked($existing)>
                                <span class="text-sm capitalize">{{ $day }}</span>
                            </label>
                            <input type="time" name="days[{{ $day }}][start_time]" value="{{ $existing?->start_time->format('H:i') }}" class="rounded-md border-gray-300 text-sm">
                            <span class="text-gray-400 text-sm">to</span>
                            <input type="time" name="days[{{ $day }}][end_time]" value="{{ $existing?->end_time->format('H:i') }}" class="rounded-md border-gray-300 text-sm">
                        </div>
                    @endforeach

                    <div class="mt-6">
                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">Save Availability</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>