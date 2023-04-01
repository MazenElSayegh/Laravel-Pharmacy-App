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
       // $allPharmacies=Pharmacy::all();
        return $dataTable->render('pharmacies.index');
        //return view('pharmacy.index', ['pharmacies' => $allPharmacies]);
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
            if ($pharmacy->image_path) {
                Storage::delete("public/" . $pharmacy->image_path);
            }
            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $path= $request->file('image')->storeAs('pharmaciesImages',$filename,'public');
            $pharmacy->image_path =$path;
            $pharmacy->save();
        }
        $path = !empty($request->file('image'))?$request->file('image')->store('pharmaciesImages',["disk"=>"public"]):"";
        $name=request()->name;
        $email=request()->email;
        $password=request()->password;
        $nationalId=request()->national_id;
        $areaId=request()->area_id;
        $priority=request()->priority;
        $pharmacy = Pharmacy::where('id',$id)->update([
            'name'=>$name,
            'email'=>$email,
            'password'=>Hash::make($password),
            'image_path'=>$path,
            'national_id'=>$nationalId,
            'area_id'=>$areaId,
            'priority'=>$priority
        ]);
        return to_route(route:'pharmacies.index');
        }

   public function store(StorePharmacyRequest $request){
            $path = !empty($request->file('image'))?$request->file('image')->store('pharmaciesImages',["disk"=>"public"]):"";
            $name=request()->name;
            $email=request()->email;
            $password=request()->password;
            $nationalId=request()->national_id;
            $areaId=request()->area_id;
            $priority=request()->priority;

            Pharmacy::create([
                'name'=>$name,
                'email'=>$email,
                'password'=>Hash::make($password),
                'image_path'=>$path,
                'national_id'=>$nationalId,
                'area_id'=>$areaId,
                'priority'=>$priority
            ]);
            return to_route(route:'pharmacies.index');
            
        }

        public function destroy($pharmacyId)
    {
        $pharmacy=Pharmacy::find( $pharmacyId);
        $pharmacy->doctors()->each(function ($doctor) {
            $doctor->delete();
            if ($doctor->image_path) {
                Storage::delete("public/" . $doctor->image_path);
            }
        });
        if ($pharmacy->image_path) {
            Storage::delete("public/" . $pharmacy->image_path);
        }
        Doctor::where('pharmacy_id', $pharmacyId)->delete();
        Pharmacy::where('id', $pharmacyId)->delete();
        return to_route('pharmacies.index');
    
    }
        
    }