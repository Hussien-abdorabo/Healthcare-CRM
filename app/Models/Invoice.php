<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable= [
        'patient_id',
        'doctor_id',
        'ammount',
        'status',
        'transaction_id',
    ];

    public function patient(){
        return $this->belongsTo(User::class,'patient_id');
    }
    public function doctor(){
        return $this->belongsTo(User::class,'doctor_id');
    }
}
