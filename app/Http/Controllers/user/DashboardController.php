<?php

namespace App\Http\Controllers\user;

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
        $patient = $user->patient;
    
        $appointmentStats = [
            'total' => $patient->totalAppointments(),
            'active' => $patient->activeAppointments(),
            'expired' => $patient->expiredAppointments(),
            'today' => $patient->todaysAppointments(),
        ];
    
        return view('user.dashboard', compact('user', 'patient', 'appointmentStats'));
    }
}
