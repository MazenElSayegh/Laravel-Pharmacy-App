<?php

namespace App\Http\Controllers;
use App\DataTables\OrdersDataTable;
use App\Http\Requests\StoreOrderRequest;
use App\Models\Address;
use App\Models\Client;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\MedicinesOrder;
use App\Models\Order;
use App\Models\Pharmacy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class OrderController extends Controller
{
       /* sign_in by admin or doctor or user pass it as argus in link.
        check using has role method

        if admin get all orders table records + order_create_by_column.

        if doctor  get all orders belongs to this pharmacy 

        if user get all orders belongs to this user only

      
        return view('orders.index');*/
        public function index(OrdersDataTable $dataTable)
    {
        
            return $dataTable->render('orders.index');
        

    }

    public function show($id)
    {
    
        $order = Order::where('id', $id)->first();
        // dd($order);
        $medicine_order = MedicinesOrder::where('order_id',$id)->get();
        // dd($medicine_order);
        // // foreach($order_medicine as $medicine){
        // //     dd($medicine);
        // // }
        // // dd($order_medicine);

        
        return view('orders.show' ,['order' => $order,'medicine_order'=>$medicine_order]);
    }

    public function create()
    {
        $allClients = Client::all();
        
        $allMedicines = Medicine::all();
        $allAddresses = Address::all();
        $allPharmacies = Pharmacy::all();
        $allDoctors = Doctor::all();

       return view('orders.create',['clients'=>$allClients,'medicines' => $allMedicines,'addresses'=>$allAddresses ,'pharmacies'=>$allPharmacies , 'doctors' =>$allDoctors ]);
    }

    public function store(StoreOrderRequest $request)
    {
        $orderTotalPrice=0;
        $medTotalPrices =request()->total_price;
        foreach($medTotalPrices as $medTotalPrice)
        {
            $orderTotalPrice+=intval($medTotalPrice);
        }
        //error if not filled
            $client_id =json_decode(request()->client_name, true)['id']; 
            $medicines =request()->medicine_name;
            // dd($medicines[0]);
            $medicine_quantity =request()->medicine_qty;
            // dd($medicine_quantity[0]);
            $is_insured =request()->is_insured;
            $doctor_id = request()->doctor_name;
            $pharmacy_id= request()->pharmacy_name;
            $address_id=request()->delivering_address;
        // dd( request()->medicine_name);
        // dd(count($medicines));
        // foreach($medicines as $medicine)
        // {
        //    $medicine=json_decode($medicine, true);

        //         // dd($medicine['id']);
            
              
        // }

       
      

        $order=Order::create([
            'is_insured'=>$is_insured,
            'total_price'=>$orderTotalPrice,
            'client_id'=>$client_id,
            'pharmacy_id'=>$pharmacy_id,
            'doctor_id'=>$doctor_id,
            'address_id'=>$address_id,
            'status'=>1,
            'creator_type'=>'doctor',
        ]);
        for($i = 0 ; $i<count($medicines);$i++){
            $medicine= json_decode($medicines[$i], true);
            $medicine_order=MedicinesOrder::create([
               
                
                'order_id' =>$order['id'],
                'medicine_id' =>$medicine['id'],
                'quantity' =>$medicine_quantity[$i],
        
            ]);
             
         }
        // dd($order['id']);
        // foreach($medicines as $medicine)
        // {
        //     dd($medicine);
        // }
        // $allData=$request->all();

        // dd($title,$description,$DoctorCreator);
        // $order=Order::create([
        //     'user_id'=> request()->user_id,
        //     'pharmacy_id'=>request()->pharmacy_id,
        //     'doctor_id'=>request()->doctor_id,
        //     'status'=>request()->status,
        //     'is_insured'=>request()->is_insured,
        //     'delivering_address'=>request()->delivering_address,
            
        // ]);
       
        // if ($request->hasFile('prescription_image')) {
        //     $image = $request->file('prescription_image');
        //     $filename = $image->getClientOriginalName();
            
        //     $path= $request->file('prescription_image')->storeAs('ordersImages',$filename,'public');
        //     $order->prescription_image =$path;
        //     $order->save();
        // }

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
    $medicine_order = MedicinesOrder::where('order_id',$id)->delete();
  
    Order::destroy($id);
  
    return redirect()->route('orders.index');
    }
}
