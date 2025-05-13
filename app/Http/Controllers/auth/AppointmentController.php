<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\{User, Patient, Doctor, Appointment};


class AppointmentController extends Controller
{
    //
    public function index() {
        // Fetch all departments and doctors from the database
        $doctors = Doctor::all();

        // Pass the data to the view
        return view('auth.appointment', compact('doctors'));
    }

    //Check Doctor`s availability
    public function checkAvailability(Request $request)
{
    $doctorId = $request->query('doctor_id');
    $date = $request->query('date');
    $time = $request->query('time');

    $exists = Appointment::where('doctor_id', $doctorId)
        ->where('appointment_date', $date)
        ->where('appointment_time', $time)
        ->exists();

    if ($exists) {
        return response()->json([
            'available' => false,
            'message' => 'The selected doctor is not available at that time. Please choose another time.',
        ]);
    }

    return response()->json(['available' => true]);
}
    public function store(Request $request)
    {
        // Validate the request
        try {
            $validatedData = $request->validate([
                'patient_name' => 'required|string',
                'phone' => 'required|string|unique:patients,mobile',
                'doctor' => 'required|exists:doctors,id',
                'date' => 'required|date',
                'time' => 'required|string',
                'email' => 'required|email|unique:users,email|unique:patients,email',
                'password' => 'required|string|min:8',
                'message' => 'nullable|string',
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            // Create a new user
            $user = User::create([
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'patient',
            ]);

            // Handle image upload
            $imageName = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/images', $imageName);
            }

            // Create a new patient
            $patient = Patient::create([
                'name' => $request->patient_name,
                'mobile' => $request->phone,
                'email' => $request->email,
                'image' => $imageName,
                'user_id' => $user->id,
            ]);

            // Create the appointment
            $appointment = Appointment::create([
                'patient_id' => $patient->id,
                'doctor_id' => $request->doctor,
                'appointment_date' => $request->date,
                'appointment_time' => $request->time,
                'message' => $request->message,
                'status' => 'pending',
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Appointment booked successfully!',
                'redirect' => '/login',
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
