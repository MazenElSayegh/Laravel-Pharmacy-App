<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PharmaciesMedicines extends Model
{
    use HasFactory;
    protected $fillable = [
        
        'medicine_id',
        'pharmacy_id',
        'quantity',
        

    ];

    public function pharmacy()
        {
            return $this->belongsTo(Pharmacy::class);
        }
    
    
    public function medicine()
        {
            return $this->belongsTo(Medicine::class);
        }
    
}
