<?php
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
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



});

