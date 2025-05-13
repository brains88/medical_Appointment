<?php

namespace App\Http\Controllers\user;

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
        // Get the authenticated user
        $user = Auth::user();
    
        // Get the patient with their appointments and related doctor/department info
        $patient = $user->patient()->with(['appointments' => function($query) {
            $query->with(['doctor' => function($q) {
                $q->select('id', 'name', 'department'); // Only select needed fields
            }])
            ->orderBy('appointment_date', 'desc'); // Show most recent first
        }])->first();
    
        // Check if patient exists
        if (!$patient) {
            return redirect()->back()->with('error', 'Patient record not found.');
        }
    
        // Log the patient data for debugging (remove in production)
        \Log::info('Patient Appointments:', [
            'patient' => $patient->toArray(),
            'appointments' => $patient->appointments->toArray()
        ]);
    
        return view('user.appointment', compact('user', 'patient'));
    }


    public function book_appointment()
    {
            // Get the authenticated user
        $user = Auth::user();

        // Get the patient details associated with the user
            $patient = $user->patient;
            $doctors = Doctor::all();

        // Pass the data to the view
        return view('user.book_appointment', compact('doctors', 'patient'));
    }

    public function save_Appointment(Request $request)
    {
        // Validate the request
        try {
            $validatedData = $request->validate([
                'doctor' => 'required|exists:doctors,id',
                'date' => 'required|date',
                'time' => 'required|string',
                'message' => 'nullable|string',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $e->errors(),
            ], 422);
        }

         // 🛡️ Check if doctor is available
         $doctorIsTaken = Appointment::where('doctor_id', $request->doctor)
         ->where('appointment_date', $request->date)
         ->where('appointment_time', $request->time)
         ->exists();

     if ($doctorIsTaken) {
         return response()->json([
             'success' => false,
             'message' => 'The selected doctor is not available at this time. Please choose another time.',
         ], 409); // 409 Conflict
     }

        // Start a database transaction
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $patient = $user->patient;

            // Create the appointment
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor,
                'appointment_date' => $request->date,
                'appointment_time' => $request->time,
                'message' => $request->message,
                'status' => 'pending',
            ]);

            // Commit the transaction
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully!',
                'redirect' => '/patient/appointment',
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error booking appointment: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while booking the appointment. Please try again.',
            ], 500);
        }
    }
}