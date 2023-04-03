<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDoctorRequest;
use App\Models\Pharmacy;
use App\Models\User;
use Spatie\Permission\Models\Role;
use App\DataTables\DoctorsDataTable;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index(DoctorsDataTable $dataTable)
    {
        $pharmacyId= auth()->user()->typeable_id;
        $pharmacy= Pharmacy::find($pharmacyId);
        $doctors=$pharmacy->doctors;
        // dd($doctors);
        return $dataTable->render('doctors.index',['doctors'=>$doctors]);
    }

    public function show($id)
    {
        $Doctor= Doctor::find($id);
        return view('doctors.show', ['doctor' => $Doctor]);
    }

    public function create()
    {
        $pharmacies= Pharmacy::all();
        return view('doctors.create',['pharmacies'=>$pharmacies]);
    }

    public function store(StoreDoctorRequest $request)
    {
        $doctor=Doctor::create([
            'national_id'=>request()->national_id,
            'pharmacy_id'=> request()->pharmacy_id,
            'is_banned'=>0,
        ]);

        $user= $doctor->type()->create([
            'name'=>request()->name,
            'email'=>request()->email,
            'password'=> Hash::make(request()->password),
        ]);

        $user->assignRole('doctor'); 

        // dd($user);

        if ($request->hasFile('avatar_image')) {
            $image = $request->file('avatar_image');
            $filename = $image->getClientOriginalName();
            $path= $request->file('avatar_image')->storeAs('doctorsImages',$filename,'public');
            $doctor->image_path =$path;
            $doctor->save();
        }

        return to_route('doctors.index');
    }

    public function edit($id)
    
    {
        $pharmacies= Pharmacy::all();
        $doctor= Doctor::find($id);
        return view('doctors.edit', ['doctor'=>$doctor, 'pharmacies'=>$pharmacies]);
    }

    public function update(StoreDoctorRequest $request,$id)
    {
        // dd($request);
        $doctor = Doctor::findOrFail($id);

        if ($request->hasFile('avatar_image')) {
            if ($doctor->image_path) {
                Storage::delete("public/" . $doctor->image_path);
            }
            $image = $request->file('avatar_image');
            $filename = $image->getClientOriginalName();
            $path= $request->file('avatar_image')->storeAs('doctorsImages',$filename,'public');
            $doctor->image_path =$path;
            $doctor->save();
        }

        $doctor->update([
            'national_id'=>request()->national_id,
            'pharmacy_id'=> request()->pharmacy_id,
            'is_banned'=>0,
        ]);

        $doctor->type()->update([
            'name'=>request()->name,
            'email'=>request()->email,
            'password'=> Hash::make(request()->password) ,
        ]);

        return redirect()->route('doctors.index');        
    }

    public function destroy($id)
    {
    $doctor = Doctor::findOrFail($id);
    Doctor::destroy($id);
    $doctor->type()->delete();
    
    if ($doctor->image_path && Storage::exists("public/". $doctor->image_path)) {
        Storage::delete( "public/". $doctor->image_path);
    }
    return redirect()->route('doctors.index');
    }

    public function ban($id)
    {
        $doctor = Doctor::findOrFail($id);
        // dd($doctor->is_banned);
        if($doctor->is_banned===0){
            $doctor->update(['is_banned'=>1]);
            // dd($doctor->is_banned);
        }
        else{
            $doctor->update(['is_banned'=>0]);
        }
        return redirect()->route('doctors.index');
    }
}
