<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','email','password','image','nationalId','areaId','priority'];

    // public function type()
    // {
    //     return $this->morphOne('User', 'typeable');
    // }

    public function doctors()
        {
            return $this->hasMany(Doctor::class);
        }
}
