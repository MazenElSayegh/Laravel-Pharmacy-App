<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function sendVerificationEmail(Request $request)
    {
        
        // if ($request->user()->hasVerifiedEmail()) {
        //     return [
        //         'message' => 'Already Verified'
        //     ];
        // }
        $userID = $request->id;
        $user = User::find($userID);
        $user->sendEmailVerificationNotification();

        return ['status' => 'verification-link-sent'];
    }


}
