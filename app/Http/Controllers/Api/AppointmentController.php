<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if($user->role =='doctor'){
            $appointments = $user->AppointmentsAsDoctor()->with('doctor')->get();
        }else{
            $appointments = $user->AppointmentsAsPatient()->with('patient')->get();
        }
        return response()->json($appointments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
           'doctor_id'=> 'required',
           'appointment_date'=> 'required | date|after:today',
        ]);

        if($user->role =='patient'){
            $appointment = Appointment::create([
                'patient_id' => auth()->id(),
                'doctor_id' => $validated['doctor_id'],
                'appointment_date' => $validated['appointment_date'],
            ]);
        }else{
            return response()->json(['message' => 'You are not authorized to book appointment ']);
       }
        return response()->json([
            "message" => "Appointment booked successfully",
            'data' => $appointment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        $appointment = Appointment::with(['patient', 'doctor'])->find($id);
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        return response()->json($appointment);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }
        if (auth()->id() !== $appointment->doctor_id ) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'appointment_status' => 'required|in:approved,rejected',
        ]);

        $appointment->update(['appointment_status' => $validated['appointment_status']]);

        return response()->json(['message' => 'Appointment status updated']);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $appointment = Appointment::find($id);
        if (!$appointment) {
            return response()->json(['message' => 'Appointment not found'], 404);
        }

        if (auth()->id() !== $appointment->patient_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $appointment->delete();

        return response()->json(['message' => 'Appointment deleted']);
    }

}
