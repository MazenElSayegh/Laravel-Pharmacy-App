<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        
        // if ($request->client()->hasVerifiedEmail()) {
        //     return [
        //         'message' => 'Already Verified'
        //     ];
        // }
        $clientID = $request->id;
        $client = User::find($clientID);
        $client->sendEmailVerificationNotification();

		return response()->json([
			'Email Sent' => 'Verification Email is sent to you email, Check out and follow the verification link',
        	'Verification Email' => 'If you didn\'t receive any verification Email click '.route('verification.resend', $client->id),
        	'Data' => $client,
            ], 403);
    }

    public function verify(Request $request)
	{
		$clientID = $request['id'];
		$client = User::findOrFail($clientID);
		$date = date("Y-m-d g:i:s");
		$client->email_verified_at = $date; 
		$client->save();
		$client->greetingClient();

		return response()->json('Congrats! Email verified');
	}

    public function resend(Request $request)
	{

		$client = User::find($request->id);
		if ($client->email_verified_at) {
		return response()->json('client already verified email', 422);
	}
		$client->sendEmailVerificationNotification();
		return response()->json('The notification has been resubmitted');
	}

}
