<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

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

        $appointment = Appointment::create([
            'patient_id' => auth()->id(),
           'doctor_id' => $validated['doctor_id'],
           'appointment_date' => $validated['appointment_date'],
        ]);
        return response()->json([
            "message" => "Appointment booked successfully",
            'data' => $appointment
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
