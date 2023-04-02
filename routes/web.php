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
Route::resource('pharmacies',PharmacyController::class);

// ------------------------------ doctors routes -----------------------------
Route::resource('doctors',DoctorController::class);
Route::get('doctors/ban/{id}',[DoctorController::class,'ban'])->name('doctors.ban')->middleware('auth','role:doctor');
// ------------------------------ orders routes -----------------------------
Route::resource('orders', OrderController::class);

// ------------------------------ medicines routes --------------------------
Route::resource('medicines', MedicineController::class);

// ------------------------------ areas routes -----------------------------
Route::resource('areas', AreaController::class);

// ------------------------------ client controller ------------------------ 
Route::resource('clients',ClientController::class);

// ------------------------------ address controller ------------------------ 

Route::resource('addresses',AddressController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
