<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Doctor;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreDoctorRequest;

class DoctorController extends Controller
{
    public function index()
    {
        $allDoctors = Doctor::all();
        // dd($allDoctors);

        return view('doctors.index', ['doctors' => $allDoctors]);
    }

    public function show($id)
    {
        $Doctor= Doctor::find($id);
        // $users= Pharmacy::all();
        // dd($user->name);

        // return view('Doctors.show', ['Doctor' => $Doctor,'users'=>$users]);
        return view('doctors.show', ['doctor' => $Doctor]);
    }

    public function create()
    {
        // dd("hello");
        $doctors= Doctor::all();
        return view('doctors.create',['doctors'=>$doctors]);
    }

    public function store(StoreDoctorRequest $request)
    {
        // $allData=$request->all();

        // dd($title,$description,$DoctorCreator);
        $doctor=Doctor::create([
            'name'=> request()->title,
            'email'=> request()->email,
            'password'=> request()->password,
            'national_id'=> request()->national_id,
            'pharmacy_id'=> request()->pharmacy_id,
        ]);
        // $slug = SlugService::createSlug(Doctor::class, 'slug', request()->title);
        if ($request->hasFile('avatar_image')) {
            $image = $request->file('avatar_image');
            $filename = $image->getClientOriginalName();
            // $path = Storage::putFileAs('public/DoctorsImages', $image, $filename);
            $path= $request->file('avatar_image')->storeAs('doctorsImages',$filename,'public');
            $doctor->image_path =$path;
            $doctor->save();
        }

        return to_route('doctors.index');
    }

    public function edit($id)
    
    {
        // $users= User::all();
        $doctor= Doctor::find($id);
        // return view('Doctors.edit',['users'=>$users], ['Doctor'=>$Doctor]);
        return view('doctors.edit', ['doctor'=>$doctor]);
    }

    public function update(StoreDoctorRequest $request,$id)
    {
        // dd($request);
        // dd($request['id'],$id,request()->id);
        $doctor = Doctor::findOrFail($id);

        if ($request->hasFile('avatar_image')) {
            if ($doctor->image_path) {
                Storage::delete("public/" . $doctor->image_path);
            }
            $image = $request->file('avatar_image');
            $filename = $image->getClientOriginalName();
            // $path = Storage::putFileAs('doctorsImages', $image, $filename);
            // $doctor->image_path = $path;
            $path= $request->file('avatar_image')->storeAs('doctorsImages',$filename,'public');
            $doctor->image_path =$path;
            $doctor->save();
        }

        // $id=request()->id;
        // dd(request(),$id);

        // $allData=$request->all();
        Doctor::where('id',$id)
            ->update([
                'name'=> request()->title,
                'email'=> request()->email,
                'password'=> request()->password,
                'national_id'=> request()->national_id,
                'pharmacy_id'=> request()->pharmacy_id,
        ]);   

        return redirect()->route('doctors.index');        
    }

    public function destroy($id)
    {
    $doctor = Doctor::findOrFail($id);
    Doctor::destroy($id);
    if ($doctor->image_path && Storage::exists("public/". $doctor->image_path)) {
        // Storage::delete($doctor->image_path);
        Storage::delete( "public/". $doctor->image_path);
    }
    return redirect()->route('doctors.index');
    }
}
