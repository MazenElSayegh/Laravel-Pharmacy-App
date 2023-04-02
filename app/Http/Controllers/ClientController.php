<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Request;
use App\Models\Client;
use App\DataTables\ClientsDataTable;
use Illuminate\Support\Facades\Storage;

class ClientController extends Controller
{
    public function index(ClientsDataTable $dataTable)
    {
        return $dataTable->render('clients.index');
    }
    

    public function show( $id)
    {
        // @dd($client);
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
            'password'=> request()->password,
        ]);

            if ($request->hasFile('avatar')) {
                $avatar = $request->file('avatar');
                $filename = $avatar->getClientOriginalName();
                $path = $request->file('avatar')->storeAs('clientImgs', $filename, 'public');
                $client->avatar_path= $path;
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
        // if ($post->image_path && Storage::exists('public/'.$post->image_path)) {
        //     Storage::delete('public/'.$post->image_path);
        // }
        $client->delete();
    
        return redirect()->route('clients.index');
        
    }

    public function update(StoreClientRequest $request,$id)
    {
        // dd($request);
        $client = Client::findOrFail($id);

        if ($request->hasFile('avatar_image')) {
            if ($client->image_path) {
                Storage::delete("public/" . $client->image_path);
            }
            $image = $request->file('avatar_image');
            $filename = $image->getClientOriginalName();
            $path= $request->file('avatar_image')->storeAs('clientsImages',$filename,'public');
            $client->image_path =$path;
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
            'password'=> request()->password,
        ]);

        return redirect()->route('clients.index');        
    }
   

}
