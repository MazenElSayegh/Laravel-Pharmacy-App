<?php

namespace App\Http\Resources;

use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class AcceptedOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $orderDetails = DB::table('medicines_orders')->where('order_id', $this->id)->get();
        $medicinesArray = [];
        // dd($orderDetails);

        foreach( $orderDetails as $order){

            $medicine = Medicine::find($order->medicine_id);

            $medicine_name = $medicine->name;
            $medicine_price = $medicine->price;
            $medicine_type = $medicine->type;
            $medicine_item = [
              'name' =>  $medicine_name,
               'price'  =>$medicine_price,
                'type' => $medicine_type ];

            $medicinesArray[]=$medicine_item;
        }
        return 
        [
            'id' => $this->id,
            'medicines' => $medicinesArray,
            'total_price' => $this->total_price,
            'ordered_at' => $this->created_at,
            'status' => $this->status,
            'assigned_pharmacy' => $this->pharmacy,
        ]; 
       }
}
