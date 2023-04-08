<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAreaRequest;
use Illuminate\Http\Request;
use App\Models\Area;
use App\DataTables\AreasDataTable;

class AreaController extends Controller
{
    public function index(AreasDataTable $dataTable)
    {
        return $dataTable->render('areas.index');
    }

    public function create() {
        return view('areas.create');
    }


    public function store(StoreAreaRequest $request) {
        Area::create([
			'name' => $request->name,
            'address' => $request->address
		]);

		return redirect()->route('areas.index');
    }

    public function show($id) {
        $area = Area::find($id);

        return view('areas.show', [
			'area' => $area
		]);
    }

    public function edit($id) {
        $area = Area::find($id);

        return view('areas.edit', [
			'area' => $area
		]);
    }

    public function update(StoreAreaRequest $request, $id) {
        $area = Area::find($id);

        $area->update([
			'name' => $request->name,
            'address' => $request->address
		]);

		return redirect()->route('areas.index');
    }

    public function destroy($id) {
        $area = Area::find($id);

      
        if($area->addresses)
        {
            return redirect()->route('areas.index');
        }
        $area->delete();

		return redirect()->route('areas.index');
    }
}
