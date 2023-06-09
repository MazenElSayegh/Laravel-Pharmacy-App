<?php

namespace App\Http\Controllers;
use App\DataTables\OrdersDataTable;
use App\Http\Requests\StoreOrderRequest;
use App\Jobs\OrdersAssignJob;
use App\Models\Address;
use App\Models\Client;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\MedicinesOrder;
use App\Models\Order;
use App\Models\Pharmacy;
use App\Models\PharmaciesMedicines;
use App\Notifications\NotifyUserOrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\NotifyClientOrderDetails;
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
        $medicine_order = MedicinesOrder::where('order_id',$id)->get();
        return view('orders.show' ,['order' => $order,'medicine_order'=>$medicine_order]);
    }

    public function create()
    {
        $allClients = Client::all();
        if(auth()->user()->hasRole('admin')){
            $allMedicines = PharmaciesMedicines::all();
        }else{
            $allMedicines = PharmaciesMedicines::where('pharmacy_id',auth()->user()->typeable_id)->get();
        }

        $Medicines = Medicine::all();
        $allAddresses = Address::all();
        $allPharmacies = Pharmacy::all();
        $allDoctors = Doctor::all();
       return view('orders.create',['clients'=>$allClients,'medicines' => $allMedicines,'addresses'=>$allAddresses ,'pharmacies'=>$allPharmacies , 'doctors' =>$allDoctors , 'meds' =>$Medicines ]);
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
            $client=json_decode(request()->client_name, true);
            
            $client_id =json_decode(request()->client_name, true)['id']; 
            $medicines =request()->medicine_name;
           
           
            // dd($medicines);
            //$pharmacy_id=json_decode(request()->pharmacy_name[0],true)['pharmacy_id'];
            if(auth()->user()->hasRole('admin')){
                $reqPharmId=json_decode(request()->pharmacy_name,true)[0]['pharmacy_id'];
            }elseif(auth()->user()->hasRole('pharmacy')){
                $reqPharmId=auth()->user()->typeable_id;
            }else{
                $reqPharmId=auth()->user()->typeable->pharmacy_id;
            }
           
            $medicine_quantity =request()->medicine_qty;
            $is_insured =request()->is_insured;
            $doctor_id = request()->doctor_name!=NULL?request()->doctor_name:"";
            $pharmacy_id= $reqPharmId;
            $address_id=request()->delivering_address;
        if(auth()->user()->hasRole('admin')){
        $order=Order::create([
            'is_insured'=>$is_insured,
            'total_price'=>$orderTotalPrice,
            'client_id'=>$client_id,
            'pharmacy_id'=>$pharmacy_id,
            'doctor_id'=>null,
            'address_id'=>$address_id,
            'status'=>3,
            'creator_type'=>'pharmacy',
        ]);
    }elseif(auth()->user()->hasRole('pharmacy')){
        $order=Order::create([
            'is_insured'=>$is_insured,
            'total_price'=>$orderTotalPrice,
            'client_id'=>$client_id,
            'pharmacy_id'=>auth()->user()->typeable_id,
            'doctor_id'=>null,
            'address_id'=>$address_id,
            'status'=>3,
            'creator_type'=>'pharmacy',
        ]);
    }else{
        $order=Order::create([
            'is_insured'=>$is_insured,
            'total_price'=>$orderTotalPrice,
            'client_id'=>$client_id,
            'pharmacy_id'=>auth()->user()->typeable->pharmacy_id,
            'doctor_id'=>auth()->user()->typeable_id,
            'address_id'=>$address_id,
            'status'=>3,
            'creator_type'=>'doctor',
        ]);
    }
        for($i = 0 ; $i<count($medicines);$i++){
            $medicine= json_decode($medicines[$i], true);
            // dd($medicine);
            $medicine_order=MedicinesOrder::create([
               
                
                'order_id' =>$order['id'],
                'medicine_id' =>$medicine['medicine_id'],
                'quantity' =>$medicine_quantity[$i],
        
            ]);
             
         }

         $medicinesPharmacy=array();
        //  dd($medicines);
         for($i = 0 ; $i<count($medicines);$i++) {
             $medicine= json_decode($medicines[$i], true);
            //  dd( $medicine);
             array_push($medicinesPharmacy,$medicine);
         }
        //  dd($pharmacy_id);
        // $object = (object)$medicines;
        // dd($object);
         $medPrice=array();
         $medName=array();
         $medQuantity=array();
       
         $pharmacyName= Pharmacy::find($pharmacy_id)->type->name;
         
      
         foreach($medicinesPharmacy as $med)
         {
            $medicineName = Medicine::find($med['medicine_id']);
            $medicineQuantity = MedicinesOrder::where('medicine_id',$med['medicine_id'])->where('order_id',$order['id'])->first();
            // dd($medicineQuantity);
            array_push($medName,$medicineName['name'] );
            array_push($medPrice,$med['price']);
            array_push($medQuantity,$medicineQuantity['quantity']);
            
         }

        //  dd($medicines , $medPrice, $medName,$medQuantity);
 
        //  dd( $medQuantity);
        //  $client = User::where('typeable_id', $client_id)->where('typeable_type',"App\Models\Client")->first();
         $client = Client::find($client_id)->type;
        //  dd($client);
         Notification::send($client,new NotifyClientOrderDetails($order,$medName,$medQuantity,$medPrice,$client,$pharmacyName));
        //  dd($medicines);

        return to_route('orders.index');
    }

    public function edit($id)
   
    {
      
        $order= Order::find($id);
        $allClients = Client::all();
        $client = Client::find($order->client_id);
       
        if(auth()->user()->hasRole('admin')){
            $allMedicines = PharmaciesMedicines::all();
        }else{
            $allMedicines = PharmaciesMedicines::where('pharmacy_id',auth()->user()->typeable_id)->get();
        }

        $allAddresses = Address::all();
        $allPharmacies = Pharmacy::all();
        $allDoctors = Doctor::all();
        
        return view('orders.edit', ['order'=>$order,'client'=>$client ,'clients'=>$allClients,'medicines' => $allMedicines,'addresses'=>$allAddresses ,'pharmacies'=>$allPharmacies , 'doctors' =>$allDoctors ]);
    }


    public function update(StoreOrderRequest $request ,$id)
    {

        $order = Order::findOrFail($id);
        if($order->pharmacy!=null){
            $pharmacyName= $order->pharmacy->type->name;
        }elseif($order->doctor!=null){
            $pharmacyName=$order->doctor->pharmacy_id;
        }else{
            $pharmacyName=null;
        }
        // dd( $pharmacyName);
    //    dd($order->pharmacy->type->name);
    
    $orderTotalPrice=0;
    $medTotalPrices =request()->total_price;
    foreach($medTotalPrices as $medTotalPrice)
    {
        $orderTotalPrice+=intval($medTotalPrice);
    }
    
        $client_id =json_decode(request()->client_name, true)['id']; 
        $medicines =request()->medicine_name;
        
        $medicine_quantity =request()->medicine_qty;
        
        $is_insured =request()->is_insured!=null?request()->is_insured:$order->is_insured;
        $doctor_id = request()->doctor_name?request()->doctor_name:$order->doctor_id;
        $pharmacy_id= request()->pharmacy_name? request()->pharmacy_name: $order->pharmacy_id;
        // dd($pharmacy_id);
        $address_id=request()->delivering_address;
   
    $medicine_order = MedicinesOrder::where('order_id',$id)->get();
    $order->update([
        'is_insured'=>$is_insured,
        'total_price'=>$orderTotalPrice,
        'client_id'=>$client_id,
        'pharmacy_id'=>$pharmacy_id,
        'doctor_id'=>$doctor_id,
        'address_id'=>$address_id,
        'status'=>3,
    ]);
   
 
    $medicine_order = MedicinesOrder::where('order_id',$id)->delete();
    for($i = 0 ; $i<count($medicines);$i++){
        $medicine= json_decode($medicines[$i], true);
        $medicine_order=MedicinesOrder::create([
           
            
            'order_id' =>$id,
            'medicine_id' =>$medicine['medicine_id'],
            'quantity' =>$medicine_quantity[$i],
    
        ]);
         
     }
     $medicinesPharmacy=array();
        //  dd($medicines);
         for($i = 0 ; $i<count($medicines);$i++) {
             $medicine= json_decode($medicines[$i], true);
            //  dd( $medicine);
             array_push($medicinesPharmacy,$medicine);
         }
        //  dd($pharmacy_id);
        // $object = (object)$medicines;
        // dd($object);
         $medPrice=array();
         $medName=array();
         $medQuantity=array();
        //  $arr =array()
        
      
         foreach($medicinesPharmacy as $med)
         {
            $medicineName = Medicine::find($med['medicine_id']);
            $medicineQuantity = MedicinesOrder::where('medicine_id',$med['medicine_id'])->where('order_id',$order['id'])->first();
            // dd($medicineQuantity);
            array_push($medName,$medicineName['name'] );
            array_push($medPrice,$med['price']);
            array_push($medQuantity,$medicineQuantity['quantity']);
            
         }

        //  dd($medicines , $medPrice, $medName,$medQuantity);
 
        //  dd( $medQuantity);
        //  $client = User::where('typeable_id', $client_id)->where('typeable_type',"App\Models\Client")->first();
         $client = Client::find($client_id)->type;
        //  dd($client);
         Notification::send($client,new NotifyClientOrderDetails($order,$medName,$medQuantity,$medPrice,$client,$pharmacyName));
        //  dd($medicines);

        return redirect()->route('orders.index');        
    }

    public function destroy($id)
    {
    $order = Order::findOrFail($id);
    $medicine_order = MedicinesOrder::where('order_id',$id)->delete();
  
    Order::destroy($id);
  
    return redirect()->route('orders.index');
    }

    public function deliver($id){
        $order = Order::findOrFail($id);
        $order->update([
            'status'=> 'Delivered',
        ]);
        return to_route('orders.index');
    }
}