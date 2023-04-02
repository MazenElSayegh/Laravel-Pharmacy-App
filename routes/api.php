<?php

use App\Http\Controllers\Api\AddressController;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\VerificationController;
use Laravel\Sanctum\Sanctum;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// ------------------------  clients routes ------------------------ 
Route::post('/clients/login', [ClientController::class,'login']);
Route::post('/clients/register', [ClientController::class ,'register']);

Route::resource('clients',ClientController::class)->middleware(['auth:sanctum','emailVerified']);


// ------------------------ Email verification ----------------------

Route::get('email/verifyLink/{id}', [VerificationController::class ,'sendVerificationEmail'])->name('verification.verifyLink');
Route::get('email/verify/{id}', [VerificationController::class ,'verify'])->name('verification.verify');
Route::get('email/resend/{id}', [VerificationController::class ,'resend'])->name('verification.resend');


// ------------------------- client's addresses Routes ---------------------------

Route::resource('addresses',AddressController::class)->middleware('auth:sanctum');


// ------------------------- Orders Routes ---------------------------

Route::post('/orders', [OrderController::class ,'store']);

