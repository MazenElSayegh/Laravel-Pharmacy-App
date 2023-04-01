<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Models\Area;
use App\Models\Client;
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
       $address = Address::find($id);



        return view('addresses.show', [
            "address" => $address
        ]);
    }


    public function create()
    {
        $areas = Area::all();
        $clients = Client::all();
        return view('addresses.create', [
            'areas' => $areas,
            'clients' => $clients
        ]);
    }

    public function store(StoreAddressRequest $request)
    {
        


        $request = $request->only([
            'area_id', 'street_name', 'build_no',
            'floor_no', 'flat_no', 'is_main', 'client_id'
        ]);

        Address::create([
            'area_id' => $request['area_id'],
            'street_name' => $request['street_name'],
            'build_no' => $request['build_no'],
            'floor_no' => $request['floor_no'],
            'flat_no' => $request['flat_no'],
            'is_main' => $request['is_main'],
            'client_id' => $request['client_id'],
        ]);
        return redirect()->route('addresses.index');
    }
    
    public function edit(StoreAddressRequest $address)
    {
    
        $clients = Client::all();
        $areas = Area::all();
        return view('addresses.edit', [
            'address' => $address,
            'clients' => $clients,
            'areas' => $areas,
        ]);
    }

    public function destroy($address)
    {      
        $address = Address::findOrFail($address);
        $address->orders()->each(function ($order){
            $order->delete();
        });
                                 
                    
        $address->delete();

        return redirect()->route('addresses.index');

    }


}
