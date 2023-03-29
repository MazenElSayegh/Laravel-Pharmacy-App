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

    // public function type()
    // {
    //     return $this->morphOne('App\User', 'typeable');
    // }
}
