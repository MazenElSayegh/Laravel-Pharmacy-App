<?php

use App\Http\Controllers\AreaController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Http\Controllers\PharmacyController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TestController;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\RevenueController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/',function(){ return to_route('login');});
Route::get('/roles', function () {
    try{
        Role::create(['name' => 'admin']);
        echo 'wooww admin created role<br>';
    }catch(Exception $ex){

        echo 'ooooo rule is taken!<br>';
    }

    try{
        Role::create(['name' => 'pharmacy']);
        echo 'wooww pharmacy created role<br>';
    }catch(Exception $ex){

        echo 'ooooo pharmacy rule is taken!<br>';
    }


    try{
        Role::create(['name' => 'doctor']);
        echo 'wooww doctor created role';
    }catch(Exception $ex){

        echo  'ooooo doctor rule is taken!';
    }
    try{
        Role::create(['name' => 'client']);
        echo 'wooww client created role';
    }catch(Exception $ex){

        echo  'ooooo doctor rule is taken!';
    }
});

// ------------------------------ pharmacies routes ---------------------
Route::group(
    ["middleware" => ['auth','role:admin']],
    function () {
        Route::get("/pharmacies", [PharmacyController::class, "index"])->name("pharmacies.index");
        Route::get("/pharmacies/create", [PharmacyController::class, "create"])->name("pharmacies.create");
        Route::post("/pharmacies", [PharmacyController::class, "store"])->name("pharmacies.store");
        Route::delete("/pharmacies/{pharmacy}", [PharmacyController::class, "destroy"])->name("pharmacies.destroy");
        Route::resource('areas', AreaController::class);
        Route::resource('clients',ClientController::class);
        Route::resource('addresses',AddressController::class);
    }
);
Route::group(
    ["middleware" => ['auth','role:admin|pharmacy']],
    function () {
        Route::get("/pharmacies/{pharmacy}", [PharmacyController::class, "show"])->name("pharmacies.show");
        Route::get("/pharmacies/{pharmacy}/edit", [PharmacyController::class, "edit"])->name("pharmacies.edit");
        Route::put("/pharmacies/{pharmacy}", [PharmacyController::class, "update"])->name("pharmacies.update");
        Route::resource('doctors',DoctorController::class);
        Route::get('doctors/ban/{id}',[DoctorController::class,'ban'])->name('doctors.ban');
        Route::get('revenues',[RevenueController::class,'index'])->name('revenues.index');
    }
);
// ------------------------------ doctors routes -----------------------------

// ------------------------------ orders routes -----------------------------
Route::group(['middleware' => ['auth','role:admin|pharmacy|doctor']], function () {
    Route::resource('orders', OrderController::class);
    Route::resource('medicines', MedicineController::class);
});

// ------------------------------ medicines routes --------------------------


// ------------------------------ areas routes -----------------------------


// ------------------------------ client controller ------------------------ 


// ------------------------------ address controller ------------------------ 



// ------------------------------ Payment controller ------------------------ 

Route::get("/payments",[PaymentController::class,'index'])->name('payments.index');
Route::get("/payments/success",[PaymentController::class,'success'])->name('payments.success');
Route::get("/payments/cancel",[PaymentController::class,'cancel'])->name('payments.cancel');
Route::post("/payments/checkout",[PaymentController::class,'checkout'])->name('payments.checkout');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get("test",function(){
    $user = User::find(2);
    // dd($user);
    $user->sendEmailVerificationNotification();

});