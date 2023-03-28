<?php

use App\Http\Controllers\DoctorController;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\Models\User;

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

Route::resource('/doctors',DoctorController::class);


// Route::resource('/posts',[]);
// Route::get('/comments',[]);
// Route::resource('/posts',function);