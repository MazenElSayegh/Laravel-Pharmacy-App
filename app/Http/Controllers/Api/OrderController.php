<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientOrderRequest;
use App\Http\Resources\AcceptedOrderResource;
use Illuminate\Http\Request;
use App\Models\client;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Resources\ClientResource;
use App\Http\Resources\OrderResource;
use App\Models\Address;
use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{

	public function index()
    {

        $orders = auth()->user()->typeable->orders;
        return OrderResource::collection($orders);
    }


	public function show($order)
	{

		$user = Auth::user();

		$exist = Order::find( $order);
		if ($exist->count() > 0) {
			$order = Order::find($order);
			if ($order->client_id == $user->typeable->id) {
				return new AcceptedOrderResource($order);
			}
		}
		return response()->json(['message' => 'Order Not Found'], 404);
	}


	public function store(StoreClientOrderRequest $request)
	{

		$address = Address::find($request->address_id);

		$user = Auth::user();
		$order = Order::create([
			'client_id' => $user->typeable->id,
			'address_id' => $address->id,
			'is_insured' => $request->is_insured,
			'status' => 'New',
			'creator_type' => 'Client',

		]);
		if ($request->hasFile('prescription_image')) {
            $avatar = $request->file('prescription_image');
            $filename = $avatar->getClientOriginalName();
            $path = $request->file('prescription_image')->storeAs('prescriptionImages', $filename, 'public');
            $order->prescription_image= $path;
            $order->save();
        }
        else{
            $path= 'defaultImages/default.jpg';
            $order->prescription_image=$path;
            $order->save();
        }

		return response()->json(new OrderResource($order), 201);
	}
	
	public function update(Request $request)
	{
		$user = Auth::user();

		$exist = Order::where('id', $request->order);

		if ($exist->count() > 0) {
			$order = Order::find($request->order);
			if ($order->client_id == $user->typeable->id) {
				if ($order->status == '1') {

					$address = Address::find($request->address_id);

					$order->update([
						'client_id' => $user->typeable->id,
						'address_id' => $address->id,
						'is_insured' => $request->is_insured,
						'status' => $request->status,
						'creator_type' => 'Client',
					]);
					if ($request->hasFile('prescription_image')) {
						$avatar = $request->file('prescription_image');
						$filename = $avatar->getClientOriginalName();
						$path = $request->file('prescription_image')->storeAs('prescriptionImages', $filename, 'public');
						$order->prescription_image= $path;
						$order->save();
					}
					else{
						$path= 'defaultImages/default.jpg';
						$order->prescription_image=$path;
						$order->save();
					}
					

					return new OrderResource($order);
				}

				return response()->json([
					'message' => 'Can\'t modify Order, it\'s already ' . $order->status
				], 400);
			}
		}
		return response()->json(['message' => 'Order Not Found'], 404);
	}

	public function confirmOrder($order){

		$order= Order::find($order);
			$order->status ="Confirmed";
			$order->save();
		
		return response()->json(['success' => 'Order is Confirmed'], 200);

	}
	public function cancelOrder($order){

		$order= Order::find($order);
			$order->status ="Canceled";
			$order->save();
		
		return response()->json(['success' => 'Order is Canceled'], 200);

	}
}
