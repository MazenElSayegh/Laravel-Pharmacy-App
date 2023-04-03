<?php

namespace App\Http\Controllers;
use App\Models\Pharmacy;
use App\Models\Doctor;
use App\Models\User;
use App\Models\Area;
use Illuminate\Http\Request;
use App\Http\Requests\StorePharmacyRequest;
use App\Http\Requests\Rule;
use App\Jobs\PruneOldPostsJob;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\DataTables\PharmaciesDataTable;
use DataTables;
class PharmacyController extends Controller
{
    public function index(PharmaciesDataTable $dataTable)
    {
        return $dataTable->render('pharmacies.index');
    }
    public function show($pharmacyId)
    {
        $pharmacy = pharmacy::find($pharmacyId);
        return view("pharmacies.show",['pharmacy' => $pharmacy]);
    }

     public function create(){
        $areas=Area::all();
        return view('pharmacies.create',['areas'=>$areas]);
    }
    public function edit($id){

        $areas=Area::all();
        $pharmacy=Pharmacy::find($id);
        return view('pharmacies.edit',['pharmacy'=>$pharmacy],['areas'=>$areas]);
    }

    public function update(StorePharmacyRequest $request,$id){
        $pharmacy = Pharmacy::findOrFail($id);

        if ($request->hasFile('avatar_image')) {
            if ($pharmacy->image_path && $pharmacy->image_path!='defaultImages/default.jpg') {
                Storage::delete("public/" . $pharmacy->image_path);
            }
            $image = $request->file('avatar_image');
            $filename = $image->getClientOriginalName();
            $path= $request->file('avatar_image')->storeAs('pharmaciesImages',$filename,'public');
            $pharmacy->image_path =$path;
            $pharmacy->save();
        }

        $pharmacy->update([
            'national_id'=>request()->national_id,
            'area_id'=> request()->area_id,
            'image_path'=>request()->image_path,
            'priority'=>request()->priority,
        ]);

        $pharmacy->type()->update([
            'name'=>request()->name,
            'email'=>request()->email,
            'password'=> Hash::make(request()->password),
        ]);

        return to_route(route:'pharmacies.index');
        }

   public function store(StorePharmacyRequest $request){
            // $path = !empty($request->file('image'))?$request->file('image')->store('pharmaciesImages',["disk"=>"public"]):"";

            $pharmacy=Pharmacy::create([
                'national_id'=>request()->national_id,
                'area_id'=> request()->area_id,
                'image_path'=>request()->image_path,
                'priority'=>request()->priority,
            ]);
    
            $user= $pharmacy->type()->create([
                'name'=>request()->name,
                'email'=>request()->email,
                'password'=> Hash::make(request()->password),
            ]);
    
            $user->assignRole('pharmacy'); 
    
            // dd($user);
    
            if ($request->hasFile('avatar_image')) {
                $image = $request->file('avatar_image');
                $filename = $image->getClientOriginalName();
                $path= $request->file('avatar_image')->storeAs('pharmaciesImages',$filename,'public');
                $pharmacy->image_path =$path;
                $pharmacy->save();
            }
            else {
                $path= 'defaultImages/default.jpg';
                // dd($path);
                $pharmacy->image_path =$path;
                $pharmacy->save();
            }
            return to_route(route:'pharmacies.index');
            
        }

        public function destroy($id)
    {
        $pharmacy=Pharmacy::find( $id);
        $pharmacy->doctors()->each(function ($doctor) {
            $doctor->delete();
            if ($doctor->image_path && $doctor->image_path!='defaultImages/default.jpg') {
                Storage::delete("public/" . $doctor->image_path);
            }
        });
        if ($pharmacy->image_path && $pharmacy->image_path!='defaultImages/default.jpg') {
            Storage::delete("public/" . $pharmacy->image_path);
        }
        Doctor::where('pharmacy_id', $id)->delete();
        Pharmacy::where('id', $id)->delete();
        $pharmacy->type()->delete();

        return to_route('pharmacies.index');
    
    }
        
    }