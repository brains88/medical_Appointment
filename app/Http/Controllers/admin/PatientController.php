<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\{User,Patient, Doctor, Appointment};
use Carbon\Carbon;
use Auth;

class PatientController extends Controller
{
    //

    public function index()
    {
        $patients = Patient::withCount(['appointments as total_appointments',
                                      'appointments as pending_appointments' => function($query) {
                                          $query->where('status', 'pending');
                                      },
                                      'appointments as active_appointments' => function($query) {
                                          $query->where('status', 'confirmed')
                                                ->where('appointment_date', '>=', Carbon::today());
                                      },
                                      'appointments as expired_appointments' => function($query) {
                                          $query->where(function($q) {
                                              $q->where('status', 'confirmed')
                                                ->where('appointment_date', '<', Carbon::today());
                                          })->orWhere('status', 'expired');
                                      }])
                            ->latest()
                            ->paginate(10);

        return view('admin.patient', compact('patients'));
    }

    public function getAppointmentStats(Patient $patient)
    {
        $today = now()->format('Y-m-d');
        
        // Get all appointments for this patient
        $appointments = Appointment::where('patient_id', $patient->id)->get();
        
        // Calculate counts
        $stats = [
            'total' => $appointments->count(),
            'pending' => $appointments->where('status', 'pending')->count(),
            'active' => $appointments->filter(function($appointment) use ($today) {
                return $appointment->status === 'confirmed' && 
                       $appointment->appointment_date >= $today;
            })->count(),
            'expired' => $appointments->filter(function($appointment) use ($today) {
                return ($appointment->status === 'confirmed' && 
                       $appointment->appointment_date < $today) ||
                       $appointment->status === 'expired';
            })->count(),
        ];
    
        return response()->json($stats);
    }


    public function deletePatient(Patient $patient)
    {
        // Delete all appointments related to this patient
        Appointment::where('patient_id', $patient->id)->delete();
        
        if ($patient->image) {
            Storage::disk('public')->delete($patient->image);
        }
        // Then delete the patient
        $patient->delete();
    
        return redirect()->route('admin.patients.index')->with('success', 'Patient and their appointments deleted successfully!');
    }
    
}
