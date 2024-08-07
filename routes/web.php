<?php

use App\Http\Controllers\ContractController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;

use App\Http\Controllers\RentalPaymentReportController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ReportGuaranteeController;
use App\Http\Controllers\ReportRentalController;
use App\Http\Controllers\StatHistoryController;
use App\Http\Controllers\SummaryBookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('5cJpjHfjkVQQqhP7KJPxBphuX5L4Wktvyq9i0EcrxVDfaRdYCU7JbifCtC5WxzVyx3a/{id}&{token}',[CustomAuthController::class,'AllowLoginConnect']);


Route::middleware(['isAuth'])->group(function () {
    Route::get('/change-password',[CustomAuthController::class,'changePassword'])->name('change.password');
    Route::post('/change-password',[CustomAuthController::class,'updatePassword'])->name('update.password');
});

Route::middleware(['alreadyLogin'])->group(function () {

    Route::get('/login',[CustomAuthController::class,'login']);
    Route::post('/login/auth',[CustomAuthController::class,'loginUser'])->name('loginUser');

});


Route::middleware(['isLogin'])->group(function () {


    Route::get('/', [MainController::class, 'index'])->name('main');

    Route::get('/logout/auth',[CustomAuthController::class,'logoutUser'])->name('logoutUser');

    Route::get('/rooms', [RoomController::class, 'index'])->name('room');
    Route::post('/rooms/store', [RoomController::class, 'store'])->name('room.store');

    Route::get('/rental',[RentalController::class,'index'])->name('rental');
    Route::post('/rental/search',[RentalController::class,'search'])->name('rental.search');
    Route::get('/rental/detail/{id}',[RentalController::class,'detail'])->name('rental.detail');
    Route::get('/rental/edit/{id}',[RentalController::class,'edit'])->name('rental.edit');
    Route::post('/rental/update', [RentalController::class, 'update'])->name('rental.update');
    Route::post('/rental/print', [RentalController::class, 'print'])->name('rental.print');
    Route::post('/rental/print/sub_apartment', [RentalController::class, 'print'])->name('rental.print.sub_apartment');
    Route::post('/rental/print/furniture', [RentalController::class, 'print'])->name('rental.print.furniture');
    Route::get('/rental/rent/{id}', [RentalController::class, 'rent'])->name('rental.rent');
    Route::get('/rental/download/{rid}/{cid}/{date1}/{date2}', [RentalController::class, 'download'])->name('rental.download');
    Route::post('/rental/recordRent', [RentalController::class, 'recordRent'])->name('rental.recordRent');
    Route::get('/rental/history/{id}', [RentalController::class, 'history'])->name('rental.history');

    //Route Contract สัญญา
    Route::get('/contract',[ContractController::class,'index'])->name('contract');
    Route::post('/contract/update',[ContractController::class,'update'])->name('contract.update');
    Route::get('/out_contract',[ContractController::class,'out_index'])->name('out_contract');
    Route::post('/out_contract/update',[ContractController::class,'out_update'])->name('out.update');
    Route::get('/room/contract',[ContractController::class,'room_con'])->name('contract.room');
    Route::post('/room/contract/search',[ContractController::class,'search'])->name('contract.search');
    Route::get('/contract/list',[ContractController::class,'list_contracct'])->name('contract.list');
    Route::post('/list/search',[ContractController::class,'list_search'])->name('list.search');

    //Route ReportRoom รายงานสรุปห้องเช่า

    Route::get('/report/room',[ReportController::class,'index'])->name('report.room');
    Route::get('/report/rental',[ReportController::class,'report_rental'])->name('report.rental');
    Route::post('/report/rental/serach',[ReportController::class,'report_search'])->name('report.search');
    Route::get('/report/rental/AvailableRoom',[ReportController::class,'avaliableRoom'])->name('report.availble');
    Route::get('/report/rental/Asset',[ReportController::class,'listRoom'])->name('report.asset');
    Route::post('/report/rental/asset/search',[ReportController::class,'asset_search'])->name('report.asset.search');

    // Report Payment
    Route::get('/report/payment',[RentalPaymentReportController::class,'index'])->name('report.payment');
    Route::post('/report/payment/search',[RentalPaymentReportController::class,'search'])->name('report.payment.search');
    Route::get('/report/payment/download/{rid}/{cid}/{date}/{status}', [RentalPaymentReportController::class, 'download'])->name('report.payment.download');
    Route::post('/report/payment/print', [RentalPaymentReportController::class, 'print'])->name('report.payment.print');

    // Report guarantee
    Route::get('/report/guarantee',[ReportGuaranteeController::class,'index'])->name('report.guarantee');
    Route::post('/report/guarantee/search',[ReportGuaranteeController::class,'search'])->name('report.guarantee.search');
    Route::post('/report/guarantee/saveData',[ReportGuaranteeController::class,'saveData'])->name('report.guarantee.saveData');

    // History Rental and Quarantee
    Route::get('/summary/history',[StatHistoryController::class,'index'])->name('summary.history');
    Route::post('/summary/history/search',[StatHistoryController::class,'search'])->name('summary.history.search');

    // Report Rental
    Route::get('/report/rent',[ReportRentalController::class,'index'])->name('report.rent');
    Route::post('/report/rent/search',[ReportRentalController::class,'search'])->name('report.rent.search');

    // Summary Booking
    Route::get('/summary/booking',[SummaryBookingController::class,'index'])->name('summary.booking');
    Route::post('/summary/booking/search',[SummaryBookingController::class,'search'])->name('summary.booking.search');

    // users
    Route::get('/users',[UserController::class,'index'])->name('user');
});

