<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;

class StaffController extends Controller
{
    public function index()
    {
        $staff = User::whereIn('role', ['doctor', 'receptionist'])
            ->orderBy('role')
            ->orderBy('name')
            ->get();

        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        return view('staff.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:doctor,receptionist',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
            'role' => $validated['role'],
        ]);

        return redirect()->route('staff.index')->with('status', 'Staff account created successfully.');
    }

    public function deactivate(User $user)
    {
        $user->update(['is_active' => false]);

        return redirect()->route('staff.index')->with('status', "{$user->name}'s account has been deactivated.");
    }

    public function activate(User $user)
    {
        $user->update(['is_active' => true]);

        return redirect()->route('staff.index')->with('status', "{$user->name}'s account has been reactivated.");
    }
}