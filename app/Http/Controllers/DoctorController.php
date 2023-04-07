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
use App\Http\Requests\UpdateDoctorRequest;
use Illuminate\Support\Facades\Hash;

class DoctorController extends Controller
{
    public function index(DoctorsDataTable $dataTable)
    {
        if(auth()->user()->hasRole('pharmacy')){
            $pharmacyId= auth()->user()->typeable_id;
            $pharmacy= Pharmacy::find($pharmacyId);
            $doctors=$pharmacy->doctors;
        }
        else{
            $doctors=Doctor::all();
        }
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
        if(auth()->user()->hasRole('pharmacy')){
            $doctor=Doctor::create([
                'national_id'=>request()->national_id,
                'is_banned'=>0,
                'pharmacy_id'=>auth()->user()->typeable_id,
            ]);  
        }
        else{
            $doctor=Doctor::create([
                'national_id'=>request()->national_id,
                'is_banned'=>0,
                'pharmacy_id'=>request()->pharmacy_id,
            ]);
        }

        $user= $doctor->type()->create([
            'name'=>request()->name,
            'email'=>request()->email,
            'password'=> Hash::make(request()->password),
        ]);

        $user->assignRole('doctor'); 

        if ($request->hasFile('avatar_image')) {
            $image = $request->file('avatar_image');
            $filename = $image->getClientOriginalName();
            $path= $request->file('avatar_image')->storeAs('doctorsImages',$filename,'public');
            $doctor->image_path =$path;
            $doctor->save();
        }
        else {
            $path= 'defaultImages/default.jpg';
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

    public function update(UpdateDoctorRequest $request,$id)
    {
        $doctor = Doctor::findOrFail($id);

        if ($request->hasFile('avatar_image')) {
            if ($doctor->image_path && $doctor->image_path!='defaultImages/default.jpg') {
                    Storage::delete("public/" . $doctor->image_path);
            }
            $image = $request->file('avatar_image');
            $filename = $image->getClientOriginalName();
            $path= $request->file('avatar_image')->storeAs('doctorsImages',$filename,'public');
            $doctor->image_path =$path;
            $doctor->save();
        }

        if(auth()->user()->hasRole('admin')){
            $doctor->update([
                'national_id'=>request()->national_id,
                'pharmacy_id'=> request()->pharmacy_id,
                'is_banned'=>0,
            ]);
        }
        else{
            $doctor->update([
                'national_id'=>request()->national_id,
                'is_banned'=>0,
            ]);
        }

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
    
    if ($doctor->image_path && Storage::exists("public/". $doctor->image_path ) && $doctor->image_path!='defaultImages/default.jpg') {
        Storage::delete( "public/". $doctor->image_path);
    }
    return redirect()->route('doctors.index');
    }

    public function ban($id)
    {
        $doctor = Doctor::findOrFail($id);
        if($doctor->is_banned===0){
            $doctor->update(['is_banned'=>1]);
        }
        else{
            $doctor->update(['is_banned'=>0]);
        }
        return redirect()->route('doctors.index');
    }
}
