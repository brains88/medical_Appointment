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


        //Update Appointment Status
        public function updateStatus(Request $request, Appointment $appointment)
        {
            $request->validate([
                'status' => 'required|in:confirmed,cancelled'
            ]);
    
            // Verify appointment is pending
            if ($appointment->status !== 'pending') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only pending appointments can be modified'
                ], 422);
            }
    
            // Update status
            $appointment->update([
                'status' => $request->status,
                'processed_by' => auth()->id(),
                'processed_at' => now()
            ]);
    
            // Send notification if needed
            // $appointment->patient->notify(new AppointmentStatusChanged($appointment));
    
            return response()->json([
                'success' => true,
                'message' => 'Appointment '.$request->status.' successfully',
                'status' => $appointment->status,
                'status_badge' => view('components.status-badge', ['status' => $appointment->status])->render()
            ]);
        }
}