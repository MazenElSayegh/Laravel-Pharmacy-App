<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price',
    ];
    public function pharmaciesMedicines(){
        
            return $this->hasMany(PharmaciesMedicines::class);
        }
    
}
