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

    public function pharmacy(){

        return $this->belongsTo(Pharmacy::class);
    }
    public function client(){

        return $this->belongsTo(Client::class);
    }
    public function doctor(){

        return $this->belongsTo(Doctor::class);
    }
    public function address(){

        return $this->belongsTo(Address::class);
    }
    
}
