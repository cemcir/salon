<?php

use App\Http\Controllers\Api\Backend\UserController;
use App\Http\Controllers\Api\Backend\PaymentController;
use App\Http\Controllers\Api\Backend\SalonController;
use App\Http\Controllers\Api\Backend\ShiftController;
use App\Http\Controllers\Api\Backend\ExpenseController;
use App\Http\Controllers\Api\Backend\CustomerController;
use App\Http\Controllers\Api\Backend\SalonTypeController;
use App\Http\Controllers\Api\Backend\MenuController;
use App\Http\Controllers\Api\Backend\DashBoardController;
use App\Http\Controllers\Api\Backend\RezervationController;
use App\Http\Controllers\Api\Backend\RezervationMenuController;
use App\Http\Controllers\Api\Backend\PaymentCustomerController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('jwt')->group(function () {  // Json Web Token İle API ları Güvence Altına Aldık

    // Ana Ekran Controller
    Route::controller(DashBoardController::class)->prefix('dashboard')->group(function () {
        Route::get('/',[DashBoardController::class,'GetByMonthNow']);
        Route::get('/{month}/{year}',[DashBoardController::class,'GetByMonthAndYear']);
    });

    Route::controller(SalonController::class)->prefix('salon')->group(function () {
        Route::post('/sil',[SalonController::class,'Delete']);
        Route::post('/guncelle',[SalonController::class,'Update']);
        Route::get('/listele',[SalonController::class,'GetAll']);
        Route::post('/ekle',[SalonController::class,'Add']);
        Route::post('/add',[SalonController::class,'SalonAdd']);
    });

    Route::controller(SalonTypeController::class)->prefix('salontur')->group(function () {
        Route::post('/ekle',[SalonTypeController::class,'Add']);
        Route::post('/sil',[SalonTypeController::class,'Delete']);
        Route::post('/guncelle',[SalonTypeController::class,'Update']);
        Route::get('/{id}',[SalonTypeController::class,'Get']);
        Route::get('/listele',[SalonTypeController::class,'GetAll']);
    });

    Route::controller(MenuController::class)->prefix('menu')->group(function () {
        Route::post('/ekle',[MenuController::class,'Add']);
        Route::post('/guncelle',[MenuController::class,'Update']);
        Route::post('/sil',[MenuController::class,'Delete']);
        Route::get('/kategori/{categoryId}',[MenuController::class,'GetAllByCategoryId']);
    });

    Route::controller(RezervationMenuController::class)->prefix('rezervasyon/menu')->group(function () {
        Route::post('/ekle',[RezervationMenuController::class,'RezervationMenuAdd']);
        Route::post('/guncelle',[RezervationMenuController::class,'RezervationMenuUpdate']);
        Route::post('/sil',[RezervationMenuController::class,'RezervationMenuDelete']);
    });

    Route::controller(PaymentController::class)->prefix('tahsilat')->group(function (){
        Route::post('/ekle',[PaymentController::class,'PaymentAdd']);
        Route::post('/sil',[PaymentController::class,'PaymentDelete']);
    });

    Route::controller(RezervationController::class)->prefix('rezervasyon')->group(function () {
        Route::get('/{rezervationId}',[RezervationController::class,'GetRezervation']);
        Route::get('/listele/{start}/{limit}',[RezervationController::class,'GetAllByLimit']);
        Route::post('/guncelle',[RezervationController::class,'RezervationUpdate']);
        Route::post('/ara',[RezervationController::class,'Search']);
    });

    Route::controller(ShiftController::class)->prefix('vardiya')->group(function () {
        Route::get('/kapat',[ShiftController::class,'Close']);
        Route::get('/ozet',[ShiftController::class,'Summar']);
    });

    // Cari Route
    Route::controller(CustomerController::class)->prefix('cari')->group(function () {
        Route::get('/{cariId}',[CustomerController::class,'Get']);
        Route::get('/listele/{start}/{limit}',[CustomerController::class,'GetAllByLimit']);
    });

    Route::controller(PaymentCustomerController::class)->prefix('cari/tahsilat')->group(function () {
        Route::get('/extre/{cariId}/{start}/{limit}',[PaymentCustomerController::class,'GetExtre']);
        Route::post('/ekle',[PaymentCustomerController::class,'CustomerPayment']);
        Route::post('/devir',[PaymentCustomerController::class,'TransferRecord']);
        Route::post('/odeme',[PaymentCustomerController::class,'CustomerDebt']);
        Route::post('/sil',[PaymentCustomerController::class,'CustomerPaymentDelete']);
    });

    Route::controller(ExpenseController::class)->prefix('gider')->group(function () {
        Route::post('/ekle',[ExpenseController::class,'ExpenseAdd']);
    });

    Route::controller(UserController::class)->prefix('kullanici')->group(function () {
        Route::post('/guncelle',[UserController::class,'UserUpdate']);
    });

});


