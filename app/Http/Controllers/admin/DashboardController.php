<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Patient, Doctor, Appointment};
use Carbon\Carbon;
use Auth;

class DashboardController extends Controller
{
    //

    public function index()
        {
            // Get all important statistics
            $stats = [
                'total_appointments' => Appointment::count(),
                'pending_appointments' => Appointment::where('status', 'pending')->count(),
                'active_appointments' => Appointment::where('status', 'confirmed')
                    ->whereDate('appointment_date', '>=', Carbon::today())
                    ->count(),
                'total_doctors' => Doctor::count(),
                'total_patients' => Patient::count(),
                'expired_appointments' => Appointment::where(function($query) {
                    $query->where('status', 'confirmed')
                        ->whereDate('appointment_date', '<', Carbon::today());
                })->orWhere('status', 'cancelled')
                  ->count(),
                'today_appointments' => Appointment::whereDate('appointment_date', Carbon::today())->count(),
            ];
    
            // Get pending appointments for the table
            $pendingAppointments = Appointment::with(['patient', 'doctor'])
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->paginate(10);
    
            return view('admin.dashboard', compact('stats', 'pendingAppointments'));
    }
}
