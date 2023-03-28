<?php

namespace App\Http\Controllers;
use App\Models\Medicine;

use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function index() {
        $medicines = Medicine::all();
        return view('medicines.index');
    }

    public function create() {
        return view('medicines.create');
    }

    public function store(Request $request) {
        Medicine::create([
			'name' => $request->name,
            'price' => $request->price,
			'type' => $request->type
		]);

		return redirect()->route('medicines.index');
    }

    public function show($id) {
        $medicine = Medicine::find($id);
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

    public function update(Request $request) {
        $medicine = Medicine::find($request->id);
        $medicine->update([
			'name' => $request->name,
            'price' => $request->price,
			'type' => $request->type
		]);

		return redirect()->route('medicines.index');
    }

    public function destroy($id) {
        $medicine = Medicine::find($id);
        $medicine->delete();
        return redirect()->route('medicines.index');
    }
}
