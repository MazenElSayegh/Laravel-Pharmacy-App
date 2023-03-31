<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;
    protected $fillable=[
        'name', 'email', 'password','gender','mobile','avatar','national_id','birth_day','password',    
    ];

    public function orders(){

        return $this->hasMany(Order::class);
    }

    public function addresses()
    {
        return $this->hasMany('Address');
    }

}
