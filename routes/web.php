<?php

use App\Http\Controllers\AreaController;
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

Route::get('/', function () {
    if(!Role::findById(1)){
        Role::create(['name' => 'writer']);
    }

    $user= User::find(2);
    $user->assignRole('writer');
    return view('test');
});

Route::get('/', function(){dd("hiiii");});
Route::get('/pharmacies/create', [PharmacyController::class, 'create'])->name('pharmacies.create');
Route::post('/pharmacies', [PharmacyController::class, 'store'])->name('pharmacies.store');
Route::get('/pharmacies/{pharmacy}', [PharmacyController::class, 'show'])->name('pharmacies.show');
Route::get('/pharmacies/{pharmacy}/edit', [PharmacyController::class, 'edit'])->name('pharmacies.edit');
Route::put('/pharmacies/{pharmacy}', [PharmacyController::class, 'update'])->name('pharmacies.update');
Route::get('/pharmacies', [PharmacyController::class, 'index'])->name('pharmacies.index');
Route::delete('/pharmacies/{pharmacy}', [PharmacyController::class, 'delete'])->name('pharmacies.delete');
Route::resource('/doctors',DoctorController::class);

Route::resource('orders', OrderController::class);

Route::resource('medicines', MedicineController::class);
Route::resource('areas', AreaController::class);


// Route::resource('/posts',[]);
// Route::get('/comments',[]);
// Route::resource('/posts',function);