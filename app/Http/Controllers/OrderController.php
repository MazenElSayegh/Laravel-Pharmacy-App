<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class OrderController extends Controller
{
    public function index()
    {
        // sign_in by admin or doctor or user pass it as argus in link.
        // check using has role method

        // if admin get all orders table records + order_create_by_column.

        // if doctor  get all orders belongs to this pharmacy 

        // if user get all orders belongs to this user only

      
        return view('order.index');

    }

    public function show($id)
    {
    
        $order = Order::where('id', $id)->first();
        return view('orders.show' ,['order' => $order]);
    }

    public function create()
    {
       
    }

    public function store(Request $request)
    {
        // $allData=$request->all();

        // dd($title,$description,$DoctorCreator);
        $order=Order::create([
            'user_id'=> request()->user_id,
            'pharmacy_id'=>request()->pharmacy_id,
            'doctor_id'=>request()->doctor_id,
            'status'=>request()->status,
            'is_insured'=>request()->is_insured,
            'delivering_address'=>request()->delivering_address,
            
        ]);
       
        if ($request->hasFile('prescription_image')) {
            $image = $request->file('prescription_image');
            $filename = $image->getClientOriginalName();
            
            $path= $request->file('prescription_image')->storeAs('ordersImages',$filename,'public');
            $order->prescription_image =$path;
            $order->save();
        }

        return to_route('orders.index');
    }

    public function edit($id)
    
    {
      
        $order= Order::find($id);
        
        return view('orders.edit', ['order'=>$order]);
    }


    public function update(Request $request,$id)
    {
        
        $order = Order::findOrFail($id);

        if ($request->hasFile('prescription_image')) {
            if ($order->prescription_image) {
                Storage::delete("public/" . $order->prescription_image);
            }
            $image = $request->file('prescription_image');
            $filename = $image->getClientOriginalName();
           
            $path= $request->file('prescription_image')->storeAs('ordersImages',$filename,'public');
            $order->prescription_image =$path;
            $order->save();
        }

       
       Order::where('id',$id)
            ->update([
                'user_id'=> request()->user_id,
                'pharmacy_id'=>request()->pharmacy_id,
                'doctor_id'=>request()->doctor_id,
                'status'=>request()->status,
                'is_insured'=>request()->is_insured,
                'delivering_address'=>request()->delivering_address,
        ]);   

        return redirect()->route('orders.index');        
    }

    public function destroy($id)
    {
    $order = Order::findOrFail($id);
    Order::destroy($id);
    if ($order->prescription_image && Storage::exists("public/". $order->prescription_image)) {
        
        Storage::delete( "public/". $order->prescription_image);
    }
    return redirect()->route('orders.index');
    }
}
