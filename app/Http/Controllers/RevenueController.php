<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;

class RevenueController extends Controller
{
    public function index(){

        //-------if pharmacy --------//
        if(auth()->user()->hasRole('pharmacy')){
            $pharmacyId= auth()->user()->typeable_id;
            $pharmacy= Pharmacy::find($pharmacyId);
            $revenue=0;
            foreach($pharmacy->orders as $order){
                $revenue+=$order->total_price;
            };
            $ordersCount=$pharmacy->orders->count();
            // dd($ordersCount);
            return view('revenues.index',['revenue'=>$revenue,'ordersCount'=>$ordersCount]);
        }
        //-------if admin--------//
        else{
            $pharmacies= Pharmacy::all();
            $totalPrice=0;
            return view('revenues.index',['pharmacies'=>$pharmacies,'totalPrice'=>$totalPrice]);
        }
    }
}
