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
<<<<<<< HEAD

    public function type()
    {
        return $this->morphOne(User::class,'typeable');
    }

=======
    public function type()
    {
        return $this->morphOne(User::class, 'typeable');
    }
>>>>>>> 267ee5c53a3accf0e2e89f987581a11e96350a3c
}
