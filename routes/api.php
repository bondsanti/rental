<?php

use App\Http\Controllers\RentalController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/rental/store',[RentalController::class,'store'])->name('rental.store');

Route::get('/rental/detail/{id}',[RentalController::class,'detail'])->name('rental.detail');
// Route::get('/rental/detail/{id}',[RentalController::class,'detail'])->name('rental.detail');