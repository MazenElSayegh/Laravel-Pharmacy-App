<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Area;

class AreaController extends Controller
{
    public function index() {
        $areas = Area::all();
        return view('areas.index', ["areas" => $areas]);
    }

    public function create() {
        return view('areas.create');
    }


    public function store(Request $request) {
        Area::create([
			'name' => $request->name
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

    public function update(Request $request) {
        $area = Area::find($request->id);

        $area->update([
			'name' => $request->name
		]);

		return redirect()->route('areas.index');
    }

    public function destroy($id) {
        $area = Area::find($id);

        $area->delete();

		return redirect()->route('areas.index');
    }
}
