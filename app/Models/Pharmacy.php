<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pharmacy extends Model
{
    use HasFactory;
    protected $fillable=[
        'name','email','password','image_path','national_id','area_id','priority'];

    // public function type()
    // {
    //     return $this->morphOne('User', 'typeable');
    // }

    public function doctors()
        {
            return $this->hasMany(Doctor::class);
        }

        public function area()
        {
            return $this->belongsTo(Area::class);
        }

    public function type()
    {
        return $this->morphOne(User::class,'typeable');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
    
}
