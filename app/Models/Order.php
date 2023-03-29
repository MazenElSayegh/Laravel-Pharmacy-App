<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
<<<<<<< HEAD
=======
    protected $fillable =[
        'user_id',
        'pharmacy_id',
        'doctor_id',
        'prescription_image',
        'status',
        'is_insured',
        'delivering_address',
       
    ];
>>>>>>> 13415db9ee721e56678109d7624acb044a19c677
}
