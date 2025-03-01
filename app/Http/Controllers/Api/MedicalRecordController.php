<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\MedicalRecord;
use Illuminate\Http\Request;


class MedicalRecordController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if($user->role == 'patient') {
            $medical_records = MedicalRecord::where('patient_id', $user->id)->get();
        }
        if($user->role == 'doctor') {
            $medical_records = MedicalRecord::all();
        }

        return response()->json([
            'medical_records' => $medical_records,
        ],200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'patient_id' => 'required|exists:users,id',
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'prescription' => 'required|string',
        ]);

        if ($user->role == 'doctor') {
            $medical_record = MedicalRecord::create([
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $user->id,
                'diagnosis' => $validated['diagnosis'],
                'treatment' => $validated['treatment'],
                'prescription' => $validated['prescription'],
            ]);

        }else{
            return response()->json(['message' => 'Unauthorized, doctor only can add medical records'], 403);
        }
        return  response()->json([
            'message' => 'Medical Record Created',
            'medical_record' => $medical_record,
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = auth()->user();
        if(!$user){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $medical_record = MedicalRecord::with( 'doctor')->find($id);
        if (!$medical_record) {
            return response()->json(['message' => 'medical record not found'], 404);
        }

        return response()->json($medical_record,200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $id)
    {

        $user = auth()->user();
        $medical_record = MedicalRecord::find($id);

        if(!$medical_record) {
            return response()->json(['message' => 'Medical Record not found'], 404);
        }

        // Only the doctor who created the record can update it
        if ($user->id !== ($medical_record->doctor_id)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // Validate the request (remove patient_id to avoid inconsistencies)
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'treatment' => 'required|string',
            'prescription' => 'required|string',
        ]);

        // Update the medical record directly
        $medical_record->update($validated);

        return response()->json([
            'message' => 'Medical Record Updated',
            'medical_record' => $medical_record,
        ]);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $medical_record = MedicalRecord::find($id);

        if (!$medical_record) {
            return response()->json(['message' => 'Medical Record not found'], 404);
        }

        if(auth()->id() !== $medical_record->doctor_id){
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $medical_record->delete();
        return response()->json([
            'message' => 'Medical Record Deleted',
        ]);
    }
}
