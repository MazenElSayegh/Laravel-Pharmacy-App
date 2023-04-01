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
    
        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function register(StoreClientRequest $request){

        // $avatar = isset($client['avatar'])? $client['avatar'] : "";
        // if ($avatar) 
        // {
        //     $new_name = time() . '_' . $avatar->getClientOriginalExtension();
        //     $avatar->move(public_path('images'), $new_name);
        // }
        // else
        // {
        //     $new_name = "default.jpg";
        // }
       
        $client=Client::create([
            'national_id'=>$request->national_id,
                'birth_day'=>$request->birth_day,
                'mobile'=>$request->mobile,
                'gender'=>$request->gender,

        ]);

         $client->type()->create([
            'name'=>request()->name,
            'email'=>request()->email,
            'password'=> Hash::make(
                request()->password),
        ]);

        $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
        // return response()->json([
        //     'success' => $success,
        //     // 'verification Link' => route('verificationapi.verifyLink', $user->id),
        //     'Data' => new ClientResource($client)
        // ], $this->successStatus);
        return new ClientResource($client);


    }




}
