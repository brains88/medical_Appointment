<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Models\{User,Patient, Doctor, Appointment};
use Carbon\Carbon;
use Auth;

class AppointmentController extends Controller
{

    public function index()
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->orderBy('appointment_date', 'desc')
            ->paginate(10);

        // Transform the items while maintaining pagination
        $transformedItems = $appointments->getCollection()->map(function ($appointment) {
            $appointment->computed_status = $this->computeStatus($appointment);
            return $appointment;
        });

        $appointments->setCollection($transformedItems);

        return view('admin.appointment', [
            'appointments' => $appointments
        ]);
    }

    protected function computeStatus($appointment)
    {
        if ($appointment->status === 'cancelled') {
            return 'cancelled';
        }

        $appointmentDate = Carbon::parse($appointment->appointment_date);
        $appointmentExpired = $appointmentDate->isPast();

        return $appointmentExpired ? 'expired' : $appointment->status;
    }

    public function showMessage(Appointment $appointment)
    {
        return response()->json([
            'message' => $appointment->message ?? 'No message provided'
        ]);
    }

    //Pending Appointment
    public function pending()
    {
        // Get pending appointments for the table
        $pendingAppointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.pending_appointment', compact('pendingAppointments'));
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
