<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Prescription;
use Illuminate\Http\Request;

class PrescriptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if(auth()->user()->role !== 'doctor') {
            return response()->json(['error' => 'Unauthorized, only doctors can create prescriptions'], 401);
        }
        $validated = $request->validate([
            'medical_record_id' => 'required|exists:medical_records,id',
            'patient_id' => 'required|exists:users,id',
            'medications' => 'required|string',
            'notes' => 'nullable|string',
        ]);
        $prescription = Prescription::create(array_merge($validated, [
            'doctor_id' => auth()->user()->id,
        ]));
        return response()->json([
            'message' => 'Prescription created',
            "prescriptions"=> $prescription],
            201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = auth()->user();
        if(!$user){
            return response()->json(['error' => 'Unauthorized , you must login first'], 401);
        }
        $prescriptions = Prescription::with(['medical_record','doctor'])->where('id',$id)->get();
        return response()->json([
            'prescriptions'=> $prescriptions
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if(auth()->user()->role !== 'doctor') {
            return response()->json(['error' => 'Unauthorized, only doctors can create prescriptions'], 401);
        }
        $prescriptions = Prescription::find($id);
        $prescriptions->update([
            $request->validate([
                'medical_record_id' => 'required|exists:medical_records,id',
                'patient_id' => 'required|exists:users,id',
                'medications' => 'required|string',
                'notes' => 'nullable|string',
            ])
        ]);
        return response()->json([
            'message' => 'Prescription updated',
            "prescriptions"=> $prescriptions
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if(auth()->user()->role !== 'doctor') {
            return response()->json(['error' => 'Unauthorized, only doctors can create prescriptions'], 401);
        }

        $prescription = Prescription::find($id);
        $prescription->delete();
        return response()->json([
            'message' => 'Prescription deleted',
        ]);
    }
}
