<?php

namespace App\Http\Controllers;
use App\Models\Pharmacy;
use App\Models\User;
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
        $users =  User::all();
        return view("pharmacy.show",['pharmacy' => $pharmacy]);
    }

     public function create(){
       // $users=User::all();
        return view('pharmacy.create');
    }
    public function edit($id){

        $users=User::all();
        $pharmacy=Pharmacy::find($id);
        return view('pharmacy.edit',['pharmacy'=>$pharmacy]);
    }

    public function update(StorePharmacyRequest $request,$id){
        $path = !empty($request->file('image'))?$request->file('image')->store('photos',["disk"=>"public"]):"";
        $name=request()->name;
        $email=request()->email;
        $password=request()->password;
        $nationalId=request()->nationalId;
        $areaId=request()->areaId;
        $priority=request()->priority;
        $pharmacyToBeUpdated=Pharmacy::find( $id);
        Storage::disk("public")->delete($pharmacyToBeUpdated->image);
        $post = Pharmacy::where('nationalId',$nationalId)->update([
            'name'=>$name,
            'email'=>$email,
            'password'=>Hash::make($password),
            'image'=>$path,
            'nationalId'=>$nationalId,
            'areaId'=>$areaId,
            'priority'=>$priority
        ]);
        return to_route(route:'pharmacies.index');
        }

   public function store(StorePharmacyRequest $request){
            $path = !empty($request->file('image'))?$request->file('image')->store('pharmaciesPhotos',["disk"=>"public"]):"";
            $name=request()->name;
            $email=request()->email;
            $password=request()->password;
            $nationalId=request()->nationalId;
            $areaId=request()->areaId;
            $priority=request()->priority;

            Pharmacy::create([
                'name'=>$name,
                'email'=>$email,
                'password'=>Hash::make($password),
                'image'=>$path,
                'nationalId'=>$nationalId,
                'areaId'=>$areaId,
                'priority'=>$priority
            ]);
            return to_route(route:'pharmacies.index');
            
        }

        public function destroy($pharmacyId)
    {
        $pharmacy=Pharmacy::find( $pharmacyId);
        Storage::disk("public")->delete($pharmacy->photo);
      //  Comment::where('commentable_id', $postId)->delete();
        Pharmacy::where('id', $pharmacyId)->delete();
        return to_route('pharmacies.index');
    }
        
    }