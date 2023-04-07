<?php

namespace App\Http\Controllers;
use App\DataTables\MedicinesDataTable;
use App\Http\Requests\StoreMedicineRequest;
use App\Models\Medicine;
use App\Models\Pharmacy;
use App\Models\PharmaciesMedicines;

use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(MedicinesDataTable $dataTable)
    {
        
        return $dataTable->render('medicines.index');
        

    }

    public function create() {
        $pharmacies = Pharmacy::all();
        $medicines= Medicine::all();
        return view('medicines.create',['pharmacies' => $pharmacies],['medicines'=>$medicines]);
    }

    public function store(StoreMedicineRequest $request) {
       
        if($request->existingMedicine=="none"){
            $request->validate([
                'name'=>['required'],
            ]);
            $request->validate([
                'type'=>['required'],
            ]);
        $medicine=Medicine::create([
			'name' => $request->name,
            'price' => $request->price,   
			'type' => $request->type
		]);
        if (auth()->user()->hasRole('pharmacy')){
            PharmaciesMedicines::create([
                   
               
                'medicine_id' =>$medicine['id'],
                'pharmacy_id' =>auth()->user()->typeable_id,
                'quantity' =>$request->quantity,
        
            ]);
        }else{
            
            PharmaciesMedicines::create([
                      
                'medicine_id' =>$medicine['id'],
                'pharmacy_id' =>$request->pharmacy_id,
                'quantity' =>$request->quantity,
            ]);
    
        }
    
    }else{
        
        $pharmaciesMedicines=PharmaciesMedicines::all();
        foreach($pharmaciesMedicines as $pharmacyMedicine){
        if($request->existingMedicine==$pharmacyMedicine->medicine_id && $request->pharmacy_id==$pharmacyMedicine->pharmacy_id){
            if(auth()->user()->hasRole('pharmacy')){
                $pharmacyMedicine->update([
                         
                    'quantity' =>$request->quantity,
            
                ]);
                return redirect()->route('medicines.index');
        }else{
            $pharmacyMedicine->update([
                 'price' =>$request->price,        
                'quantity' =>$request->quantity,
        
            ]);
            return redirect()->route('medicines.index');
        }
    }
        if (auth()->user()->hasRole('pharmacy')){
        $pharmaciesMedicines=auth()->user()->typeable->pharmaciesMedicines;
    
        foreach($pharmaciesMedicines as $pharmacyMedicine){
         if($pharmacyMedicine->medicine_id==$request->existingMedicine){
            
            $pharmacyMedicine->update([
                         
                'quantity' =>$request->quantity,
        
            ]);
            return redirect()->route('medicines.index');
        }
    }

        PharmaciesMedicines::create([
               
            'price' => $request->price,   
            'medicine_id' =>$request->existingMedicine,
            'pharmacy_id' =>auth()->user()->typeable_id,
            'quantity' =>$request->quantity,
    
        ]);
        
    }else{
        PharmaciesMedicines::create([
            'price' => $request->price,   
            'medicine_id' =>$request->existingMedicine,
            'pharmacy_id' =>$request->pharmacy_id,
            'quantity' =>$request->quantity,
        ]);

    }


		return redirect()->route('medicines.index');
    }
    }
}

    public function show($id) {
        $medicine = PharmaciesMedicines::find($id);
        return view('medicines.show', [
			'medicine' => $medicine
		]);
    }

    public function edit($id) {

        $medicine = Medicine::find($id);
        return view('medicines.edit', [
			'medicine' => $medicine
		]);
        
    }

    public function update(StoreMedicineRequest $request, $id) {
        $pharmacyMedicine = PharmaciesMedicines::find($id);
        $medicineID=$pharmacyMedicine->medicine_id;
        $medicine=Medicine::find($medicineID);
        $pharmacyMedicine->update([
            'price' => $request->price,
            'quantity' => $request->quantity
		]);


		return redirect()->route('medicines.index');
    }

    public function destroy($id) {
        PharmaciesMedicines::find($id)->delete();
       
        return redirect()->route('medicines.index');
    }
}
