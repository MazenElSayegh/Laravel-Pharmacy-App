<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index(){
        $totalOrders= Order::all();
        $userId= auth()->user()->id;
        $order= Order::where('pharmacy_id',$userId);
        $totalPrice=0;
        $pharmacies= Pharmacy::all();
        $ordersCount= Order::count();
        foreach($totalOrders as $order){
            $totalPrice+=$order->total_price;
        }
        $pharmacy=Pharmacy::find(1);
        dd($pharmacy->orders);
        // dd($order);
        return view('revenues.index',['totalPrice'=>$totalPrice,'pharmacies'=>$pharmacies,'orders'=>$ordersCount]);
    }
}
