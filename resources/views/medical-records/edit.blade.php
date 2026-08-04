<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Medical Record</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow sm:rounded-lg">

                @if ($record->attachments->count())
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">Existing attachments</p>
                        @foreach ($record->attachments as $attachment)
                            <div class="flex items-center justify-between text-sm border rounded-md px-3 py-2 mb-1">
                                <a href="{{ Storage::disk('attachments')->temporaryUrl($attachment->file_path, now()->addMinutes(30)) }}" target="_blank" class="text-blue-600">{{ $attachment->original_name }}</a>
                                <form method="POST" action="{{ route('attachments.destroy', $attachment) }}" onsubmit="return confirm('Remove this file?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 text-xs">Remove</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif

                <form method="POST" action="{{ route('records.update', $record) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <label class="block text-sm text-gray-600">Notes</label>
                    <textarea name="notes" rows="6" class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes', $record->notes) }}</textarea>
                    @error('notes') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror

                    <label class="block text-sm text-gray-600 mt-4">Add more attachments (optional)</label>
                    <input type="file" name="attachments[]" multiple class="mt-1 block w-full text-sm">

                    <div class="mt-6 flex gap-2">
                        <a href="{{ route('patients.show', $record->patient_id) }}" class="px-4 py-2 border rounded-md text-sm text-gray-600">Cancel</a>
                        <button type="submit" class="px-4 py-2 bg-gray-900 text-white rounded-md text-sm">Update Record</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>