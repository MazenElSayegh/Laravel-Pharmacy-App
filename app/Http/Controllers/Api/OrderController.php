<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ClientResource;
use App\Http\Resources\OrderResource;
use App\Models\Client;
use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function store(Request $request){
        $recievedOrder = $request->only(['is_insured', 'delivering_address_id', 'image']);

		// $useradd = UserAddress::find($recievedOrder['delivering_address_id']);
		// $pharmacy = Pharmacy::where('area_id', $useradd->area_id)->orderby('priority', 'desc')->first();

		$user = Auth::user();

		$order = Order::create([
			'user_id' => $user->typeable->id,
			'userAddress_id' => $recievedOrder['delivering_address_id'],
			'doctor_id' => null,
			'is_insured' => $recievedOrder['is_insured'],
			'status' => 'New',
			// 'pharmacy_id' => $pharmacy->id,
			'Actions' => '--',
			'creator_type' => 'Client'
		]);

		$this->orderPrescription($request->file('image'), $order);
		return response()->json(new OrderResource($order), 201);
    }
}
