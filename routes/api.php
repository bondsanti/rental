<?php

use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportGuaranteeController;
use App\Http\Controllers\UserController;
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
Route::get('/rental/getLeaseCode/{id}',[RentalController::class,'getLeaseCode'])->name('rental.getLeaseCode');
Route::get('/rental/detail/{id}',[RentalController::class,'detail'])->name('rental.detail');
Route::delete('/rental/destroy/{id}',[RentalController::class,'destroy'])->name('rental.destroy');

Route::get('/rental/rent/preapprove/{id}',[RentalController::class,'preapprove'])->name('rental.rent.preapprove');
Route::post('/rental/rent/approve/{id}/{status}/{index}',[RentalController::class,'approve'])->name('rental.rent.approve');
Route::get('/rental/provinces',[RentalController::class,'getProvinces'])->name('rental.provinces');
Route::get('/rental/amphoes',[RentalController::class,'getAmphoes'])->name('rental.amphoes');
Route::get('/rental/tambons',[RentalController::class,'getTambons'])->name('rental.tambons');
Route::get('/rental/zipcodes',[RentalController::class,'getZipcodes'])->name('rental.zipcodes');

Route::post('/report/guarantee/updateBank/{pid}/{bankId}/{bankName}',[ReportGuaranteeController::class,'updateBank'])->name('report.guarantee.updateBank');

Route::post('/user/store',[UserController::class,'store'])->name('user.store');
Route::get('/user/edit/{id}',[UserController::class,'edit'])->name('user.edit');
Route::post('/user/update/{id}',[UserController::class,'update'])->name('user.update');
Route::delete('/user/destroy/{id}/{user_id}',[UserController::class,'destroy'])->name('user.destroy');