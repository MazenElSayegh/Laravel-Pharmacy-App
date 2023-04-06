<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public $successStatus = 200;


    public function index()
    {
        return ClientResource::collection(
            Client::all()
        );
    }


    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
            
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['incorrect email or password.'],
            ]);
        }
        Auth::login($user);

        $userLoginDate = $user;
        if($userLoginDate->hasrole('client')){
            $userLoginDate->typeable->last_login = now();
            $userLoginDate->typeable->save();
        };
        return [
            'Access Token' => $user->createToken($request->device_name)->plainTextToken,
            'Data' => new ClientResource(
                Client::find($user->typeable->id)
            )
        ];
    }

    public function register(StoreClientRequest $request){

        $client=Client::create([
            'national_id'=>$request->national_id,
            'birth_day'=>$request->birth_day,
            'mobile'=>$request->mobile,
            'gender'=>$request->gender,

        ]);

       $user = $client->type()->create([
            'name'=>request()->name,
            'email'=>request()->email,
            'password'=> Hash::make(
                request()->password),
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
        $user->assignRole('client'); 

        
        $user->sendEmailVerificationNotification();

        $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
        return response()->json([
            'success' => $success,
            'verification Link' => route('verification.verifyLink', $client->id),
            'Data' => new ClientResource($client)
        ], $this->successStatus);
        return new ClientResource($client);


    }
   
    public function show($client)
    {
        $exist = Client::where('id', $client);
        if ($exist->count()>0) 
        {
            return new ClientResource(
                Client::find(User::find($client)->typeable->id)
            );
        }
        else
        {
            return response()->json([
                "message" => "client is not found"
            ], 404);
        }
    }


    
    public function destroy($client)
    { 
        $clientId = User::find($client)->typeable->id;
        Client::find($clientId)->delete();
        User::find($client)->delete();
        return response()->json([
            'success' => 'Client deleted successfully'
        ], 200);
    }

    public function update(StoreClientRequest $request)
    {
        $exist = Client::where('id', $request->client);
        if ($exist->count()>0) 
        {
            $clientUser = $request->only(['name', 'email' ,'national_id', 'avatar', 'gender', 'birth_day', 'mobile']);
            

           $user = User::find($request->client);
           $client = Client::find($user->typeable->id);

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


            return new ClientResource($client);
        }
        else
        {
            return response()->json([
                "message" => "client not found"
            ], 404);
        }

    }

}
