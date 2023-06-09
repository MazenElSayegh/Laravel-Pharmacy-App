<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Request;
use App\Models\Client;
use App\DataTables\ClientsDataTable;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class ClientController extends Controller
{
    public function index(ClientsDataTable $dataTable)
    {
        return $dataTable->render('clients.index');
    }
    

    public function show( $id)
    {
       $client = Client::find($id);
       
        return view('clients.show', [
            "client" => $client
        ]);
    }

    public function create(Request $request){

        return view('clients.create');

    }

    

    public function store(StoreClientRequest $request){

       
         
        $client=Client::create([
            'national_id'=>$request->national_id,
                'birth_day'=>$request->birth_day,
                'mobile'=>$request->mobile,
                'gender'=>$request->gender,

        ]);

         $client->type()->create([
            'name'=>request()->name,
            'email'=>request()->email,
            'password'=> Hash::make(request()->password),
        ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = $avatar->getClientOriginalName();
                $path = $request->file('avatar')->storeAs('clientImages', $filename, 'public');
                $client->avatar= $path;
                $client->save();
            }
            else{
                $path= 'defaultImages/default.jpg';
                $client->avatar =$path;
                $client->save();
            }
    
            return redirect()->route('clients.index');
            
    }

    public function edit($client){
        $client = Client::find($client);
        
        return view('clients.edit', ['client' => $client]);
    }

    public function destroy($client){
        
        $client = Client::findOrFail($client);
        if ($client->avatar && $client->avatar!='defaultImages/default.jpg') {
            Storage::delete('public/'.$client->avatar);
        }
        $client->delete();
    
        return redirect()->route('clients.index');
        
    }

    public function update(UpdateClientRequest $request,$id)
    {
        $client = Client::findOrFail($id);

        if ($request->hasFile('avatar')) {
            if ($client->avatar && $client->avatar!='defaultImages/default.jpg') {
                Storage::delete("public/" . $client->avatar);
            }
            $image = $request->file('avatar');
            $filename = $image->getClientOriginalName();
            $path= $request->file('avatar')->storeAs('clientImages',$filename,'public');
            $client->avatar =$path;
            $client->save();
        }

        $client->update([
            'national_id'=>$request->national_id,
                'birth_day'=>$request->birth_day,
                'mobile'=>$request->mobile,
                'gender'=>$request->gender,
        ]);

        $client->type()->update([
            'name'=>request()->name,
            'email'=>request()->email,
            'password'=> Hash::make(request()->password),
        ]);

        return redirect()->route('clients.index');        
    }
   

}
