<?php
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\http\Controllers\ContractController;
use App\http\controllers\ReportRoomController;
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



Route::get('_997744Isfnj)asdjknjZqwnmPOdfk_HHHGsfbp7AscaYjsn_asj20Ssdszf96GH645G1as41s_sdfnjozz/{id}&{token}',[CustomAuthController::class,'AllowLoginConnect']);


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
    Route::get('/rental/download/{id}/{date}', [RentalController::class, 'download'])->name('rental.download');
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
    Route::get('/report/room',[ReportRoomController::class,'index'])->name('report.room');
    Route::get('/report/rental',[ReportRoomController::class,'report_rental'])->name('report.rental');
    Route::post('/report/rental/serach',[ReportRoomController::class,'report_search'])->name('report.search');
    Route::get('/report/rental/AvailableRoom',[ReportRoomController::class,'avaliableRoom'])->name('report.availble');
    Route::get('/report/rental/Asset',[ReportRoomController::class,'listRoom'])->name('report.asset');
    Route::post('/report/rental/asset/search',[ReportRoomController::class,'asset_search'])->name('report.asset.search');

});

