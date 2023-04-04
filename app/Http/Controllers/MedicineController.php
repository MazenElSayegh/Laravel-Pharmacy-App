<?php

namespace App\Http\Controllers;
use App\DataTables\MedicinesDataTable;
use App\Http\Requests\StoreMedicineRequest;
use App\Models\Medicine;
use App\Models\PharmaciesMedicines;

use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index(MedicinesDataTable $dataTable)
    {
            return $dataTable->render('medicines.index');
        

    }

    public function create() {
        return view('medicines.create');
    }

    public function store(StoreMedicineRequest $request) {
        $medicine=Medicine::create([
			'name' => $request->name,
            'price' => $request->price,
			'type' => $request->type
		]);
        PharmaciesMedicines::create([
               
                
            'medicine_id' =>$medicine['id'],
            'pharmacy_id' =>auth()->user()->typeable_id,
            'quantity' =>$request->quantity,
    
        ]);

		return redirect()->route('medicines.index');
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
        $medicine->update([
			'name' => $request->name,
            'price' => $request->price,
			'type' => $request->type,
		]);
        
        $pharmacyMedicine->update([
			'medicine_id' => $medicineID,
            'quantity' => $request->quantity
		]);


		return redirect()->route('medicines.index');
    }

    public function destroy($id) {
        PharmaciesMedicines::find($id)->delete();
       
        return redirect()->route('medicines.index');
    }
}
