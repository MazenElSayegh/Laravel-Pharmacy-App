<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ClientResource;
use App\Models\Client;


class ClientController extends Controller
{
    public $successStatus = 200;

    public function login(Request $request) {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'device_name' => 'required',
            
        ]);
    
        $user = User::where('email', $request->email)->first();
    
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
    
        return $user->createToken($request->device_name)->plainTextToken;
    }

    public function register(Request $request){

        $client = $request->only(['name', 'email','password' ,'national_id', 'avatar', 'gender', 'birth_day', 'mobile']);
        $avatar = isset($client['avatar'])? $client['avatar'] : "";
        if ($avatar) 
        {
            $new_name = time() . '_' . $avatar->getClientOriginalExtension();
            $avatar->move(public_path('images'), $new_name);
        }
        else
        {
            $new_name = "default.jpg";
        }
       
        $user = User::create([
            'name'=> $client['name'],
            'email'=> $client['email'],
            'password' => Hash::make($client['password']),

        ]);
        $clientUser = Client::create([
            'national_id' => $client['national_id'],
            'avatar' => $new_name,
            'gender' => $client['gender'],
            'birth_day' => $client['birth_day'],
            'mobile' => $client['mobile'],
            'last_login' => now(),
        ]);

        $success['message'] = 'Please confirm yourself by clicking on verify user button sent to you on your email';
        // return response()->json([
        //     'success' => $success,
        //     // 'verification Link' => route('verificationapi.verifyLink', $user->id),
        //     'Data' => new ClientResource($clientUser)
        // ], $this->successStatus);
        return new ClientResource($clientUser);


    }




}
