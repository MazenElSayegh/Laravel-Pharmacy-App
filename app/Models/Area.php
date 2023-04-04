<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', 'address'
    ];

    public function addresses()
        {
            return $this->hasMany(Address::class);
        }
    public function pharmacies(){
        return $this->hasMany(Pharmacy::class);
    }
}
