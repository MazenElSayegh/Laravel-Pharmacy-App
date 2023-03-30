<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    public function index()
    {
        $addresses=Address::all();
        return view('addresses.index',['addresses'=>$addresses]);
    }

    public function show( $id)
    {
        // @dd($client);
       $addresses = Address::find($id);



        return view('addresses.show', [
            "addresses" => $addresses
        ]);
    }
}
