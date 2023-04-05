<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Doctor extends Model
{
    use HasFactory;
    use HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'national_id',
        'avatar_image',
        'pharmacy_id',
        'is_banned',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function type()
    {
        return $this->morphOne(User::class, 'typeable');
    }

    public function pharmacy()
    {
        return $this->belongsTo(Pharmacy::class);
    }

    public function orders(){

        return $this->hasMany(Order::class);
    }

    protected $dates = [
        'created_at',
        'updated_at'
    ];

    protected $dateFormat = 'Y-m-d';
   
}
