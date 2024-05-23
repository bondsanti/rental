<?php

use App\Http\Controllers\RentalController;
use App\Http\Controllers\ReportGuaranteeController;
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

Route::get('/rental/rent/preapprove/{id}',[RentalController::class,'preapprove'])->name('rental.rent.preapprove');
Route::post('/rental/rent/approve/{id}/{status}/{index}',[RentalController::class,'approve'])->name('rental.rent.approve');

Route::post('/report/guarantee/updateBank/{pid}/{bankId}/{bankName}',[ReportGuaranteeController::class,'updateBank'])->name('report.guarantee.updateBank');
