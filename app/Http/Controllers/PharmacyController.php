<?php

namespace App\Http\Controllers;
use App\Models\Order;
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
        $pharmacies = Pharmacy::onlyTrashed()
                ->get();
        $users= User::onlyTrashed()
                ->get();  
        $areas= Area::onlyTrashed()
                ->get();  
        return $dataTable->render('pharmacies.index',['pharmacies' => $pharmacies],['users' => $users]);
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
        if($pharmacy->orders()->exists()){
                    return to_route('pharmacies.index');
            }else{
       
        $pharmacy->doctors()->each(function ($doctor) {
            if ($doctor->image_path && $doctor->image_path!='defaultImages/default.jpg') {
                Storage::delete("public/" . $doctor->image_path);
                
            }
            if( $doctor->orders()->exists()){ 
                return to_route('pharmacies.index');
                }
        });
        if ($pharmacy->image_path && $pharmacy->image_path!='defaultImages/default.jpg') {
            Storage::delete("public/" . $pharmacy->image_path);
        }
        $pharmacy->doctors()->each(function ($doctor) {
            if(!$doctor->orders()->exists()){
                $doctor->delete();
                
            }
        });
        if(!$pharmacy->doctors()->exists()){
        $pharmacy->delete();
        $pharmacy->type()->delete();
        }
        return to_route('pharmacies.index'); 
      
    }
       
    
    }
    public function restore($id){
        Pharmacy::withTrashed()
        ->where('id', $id)
        ->restore();
            User::withTrashed()
            ->where('typeable_id', $id)
            ->restore();
        
        return to_route('pharmacies.index'); 
    }
}
