<?php

namespace App\Http\Controllers\doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\{User,Patient, Doctor, Appointment};
use Auth;

class AppointmentController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();
        $doctor = $user->doctor()->with(['appointments.patient'])->first();
        
        if (!$doctor) {
            return redirect()->back()->with('error', 'Doctor record not found.');
        }
        
        return view('doctor.appointment', compact('user', 'doctor'));
    }


}