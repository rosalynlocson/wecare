<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    public function destroy(Attachment $attachment)
    {
        $doctorId = $attachment->medicalRecord->appointment->doctor_id;
        $user = auth()->user();

        if (! $user->isAdmin() && $user->id !== $doctorId) {
            abort(403);
        }

        Storage::disk('attachments')->delete($attachment->file_path);
        $attachment->delete();

        return redirect()->back()->with('status', 'Attachment removed.');
    }
}