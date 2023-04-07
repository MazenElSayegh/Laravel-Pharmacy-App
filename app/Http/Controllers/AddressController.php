<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Models\Address;
use App\Models\Area;
use App\Models\Client;
use Illuminate\Http\Request;
use App\DataTables\AddressesDataTable;
use Illuminate\Support\Facades\Storage;

class AddressController extends Controller
{
    public function index(AddressesDataTable $dataTable)
    {
        return $dataTable->render('addresses.index');
    }

    public function show( $id)
    {
       $address = Address::find($id);



        return view('addresses.show', [
            "address" => $address
        ]);
    }


    public function create()
    {
        $areas = Area::all();
        $addresses = Address::all();
        $clients=Client::all();

        return view('addresses.create', [
            'areas' => $areas,
            'addresss' => $addresses,
            'clients'=>$clients
        ]);
    }

    public function store(StoreAddressRequest $request)
    {
        


        $request = $request->only([
            'area_id', 'street_name', 'build_no',
            'floor_no', 'flat_no', 'is_main','client_id'
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
    
    public function edit($id)
    {
    
        $address = Address::find($id);
        $areas = Area::all();
        $clients = Client::all();
       
        return view('addresses.edit', [
            'clients'=> $clients,
            'address' => $address,
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

    public function update(StoreAddressRequest $request,$id)
    {
        $address = Address::findOrFail($id);

        if ($request->hasFile('avatar_image')) {
            if ($address->image_path) {
                Storage::delete("public/" . $address->image_path);
            }
            $image = $request->file('avatar_image');
            $filename = $image->getClientOriginalName();
            $path= $request->file('avatar_image')->storeAs('addressesImages',$filename,'public');
            $address->image_path =$path;
            $address->save();
        }

        $address->update([
            'area_id' => $request['area_id'],
            'street_name' => $request['street_name'],
            'build_no' => $request['build_no'],
            'floor_no' => $request['floor_no'],
            'flat_no' => $request['flat_no'],
            'is_main' => $request['is_main'],
            'address_id' => $request['address_id'],
        ]);

       

        return redirect()->route('addresses.index');        
    }


}
