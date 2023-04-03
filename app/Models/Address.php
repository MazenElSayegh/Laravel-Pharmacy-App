<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Controllers\AddressController;

class Address extends Model
{
    use HasFactory;

    protected $fillable=[
        'area_id','street_name'
        ,'build_no','floor_no'
        ,'flat_no','is_main', 'client_id'
    ];

    public function area(){
        return $this->belongsTo(Area::class);
    }
   
   
    public function orders(){

        return $this->hasMany(Order::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    
}
