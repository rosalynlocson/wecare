<?php

namespace App\Http\Controllers;

use App\Models\Availability;
use App\Models\User;
use Illuminate\Http\Request;

class AvailabilityController extends Controller
{
    private array $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];

    public function edit(User $doctor)
    {
        $this->authorizeAccess($doctor);

        $availabilities = $doctor->availabilities()->get()->keyBy('day_of_week');

        return view('availability.edit', [
            'doctor' => $doctor,
            'availabilities' => $availabilities,
            'days' => $this->days,
        ]);
    }

    public function update(Request $request, User $doctor)
    {
        $this->authorizeAccess($doctor);

        $validated = $request->validate([
            'days' => 'array',
            'days.*.enabled' => 'nullable|boolean',
            'days.*.start_time' => 'nullable|required_with:days.*.enabled|date_format:H:i',
            'days.*.end_time' => 'nullable|required_with:days.*.enabled|date_format:H:i|after:days.*.start_time',
        ]);

        $doctor->availabilities()->delete();

        foreach ($validated['days'] ?? [] as $day => $data) {
            if (! empty($data['enabled'])) {
                $doctor->availabilities()->create([
                    'day_of_week' => $day,
                    'start_time' => $data['start_time'],
                    'end_time' => $data['end_time'],
                ]);
            }
        }

        return redirect()->route('availability.edit', $doctor)->with('status', 'Availability updated successfully.');
    }

    private function authorizeAccess(User $doctor): void
    {
        // The target user must actually be a doctor — prevents /doctors/{id}/availability
        // from working against a receptionist or admin's user ID.
        if (! $doctor->isDoctor()) {
            abort(404);
        }

        $user = auth()->user();

        // Admin can edit any doctor's availability; a doctor can only edit their own.
        if (! $user->isAdmin() && $user->id !== $doctor->id) {
            abort(403);
        }
    }
}