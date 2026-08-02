<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Invoice;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return $this->adminDashboard();
        }

        // Doctors and receptionists land on today's appointment list instead
        return redirect()->route('appointments.index');
    }

    private function adminDashboard()
    {
        $today = Carbon::today();
        $weekStart = $today->copy()->startOfWeek();
        $weekEnd = $today->copy()->endOfWeek();

        $todayCount = Appointment::whereDate('appointment_date', $today)
            ->where('status', '!=', 'cancelled')
            ->count();

        $weekCount = Appointment::whereBetween('appointment_date', [$weekStart, $weekEnd])
            ->where('status', '!=', 'cancelled')
            ->count();

        $todayRevenue = Invoice::whereHas('appointment', function ($q) use ($today) {
                $q->whereDate('appointment_date', $today);
            })
            ->where('status', 'paid')
            ->sum('amount');

        $weekRevenue = Invoice::whereHas('appointment', function ($q) use ($weekStart, $weekEnd) {
                $q->whereBetween('appointment_date', [$weekStart, $weekEnd]);
            })
            ->where('status', 'paid')
            ->sum('amount');

        $unpaidCount = Invoice::where('status', 'unpaid')->count();

        return view('dashboard', compact('todayCount', 'weekCount', 'todayRevenue', 'weekRevenue', 'unpaidCount'));
    }
}