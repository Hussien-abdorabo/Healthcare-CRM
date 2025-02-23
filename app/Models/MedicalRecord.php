<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Testing\Fluent\Concerns\Has;

class MedicalRecord extends Model
{
    use HasFactory;
    protected $fillable =[
        'patient_id',
        'doctor_id',
        'diagnosis',
        'treatment',
        'attachment',
    ];
    public function patient(){
        return $this->belongsTo(User::class,'patient_id');
    }
    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }
}
