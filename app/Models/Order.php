<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable =[
        'user_id',
        'pharmacy_id',
        'doctor_id',
        'prescription_image',
        'status',
        'is_insured',
        'delivering_address',
        'total_price',
        'creator_type',
       
    ];
}
