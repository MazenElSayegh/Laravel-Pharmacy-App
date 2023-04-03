<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAddressRequest;
use App\Http\Resources\AddressResource;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $Addresses = Address::all();
        return AddressResource::collection($Addresses);
    }

    public function show(Address $Address)
    {

        return new AddressResource($Address);
    }



    public function update(StoreAddressRequest $request)
    {

        $address = Address::find($request->Address);
        $request = $request->only([
            'area_id', 'street_name', 'build_no',
            'floor_no', 'flat_no', 'is_main'
        ]);
        $address->update([
            'area_id' => $request['area_id'],
            'street_name' => $request['street_name'],
            'build_no' => $request['build_no'],
            'floor_no' => $request['floor_no'],
            'flat_no' => $request['flat_no'],
            'is_main' => $request['is_main'],


        ]);
        return response()->json('updated');
    }

    public function store(StoreAddressRequest $request)
    {

        $user = Auth::user();

        $request = $request->only([
            'area_id', 'street_name', 'build_no',
            'floor_no', 'flat_no', 'is_main'
        ]);

        Address::create([
            'area_id' => $request['area_id'],
            'street_name' => $request['street_name'],
            'build_no' => $request['build_no'],
            'floor_no' => $request['floor_no'],
            'flat_no' => $request['flat_no'],
            'is_main' => $request['is_main'],
            'client_id' => $user->typeable_id,
        ]);
        return response()->json('Address Added Successful');
    }

    public function destroy(Address $Address)
    {

        $Address->delete();
        return response()->json('Address Deleted Successful');
    }


}
