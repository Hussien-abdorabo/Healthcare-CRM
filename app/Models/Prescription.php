<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id',
        'patient_id',
        'medical_record_id',
        'medications',
        'notes',
        'sent_via_whatsapp',
    ];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function patient(){
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function medical_record(){
        return $this->belongsTo(MedicalRecord::class, 'medical_record_id');
    }
}
