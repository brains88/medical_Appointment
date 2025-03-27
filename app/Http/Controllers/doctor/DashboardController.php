<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User,Patient, Doctor, Department};
use Auth;

class DashboardController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();
        $doctor = $user->doctor; 
        
        $appointmentStats = [
            'total' => $doctor->appointments()->count(),
            'active' => $doctor->activeAppointments(),
            'expired' => $doctor->expiredAppointments(),
            'today' => $doctor->todaysAppointments(),
        ];
    
        return view('doctor.dashboard', compact('user', 'doctor', 'appointmentStats'));
    }
}
