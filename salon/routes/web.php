<?php

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

// BURASI DENEME AMAÇLI KULLANILDI ROUTE LAR api.php de

Route::get('/', function () {
    return view('course');
})->name('welcome');

Route::get('newpage/{ad}/{soyad}',function($ad,$soyad) {
    //return view('newpage');
    return $ad." ".$soyad;
//})->where('ad','[0-9]+');
})->where(['ad'=>'[a-z]+','soyad'=>'[a-zA-Z]+'])->name('newPageParam');

/*
Route::match(['post','get'],'post',function () {
    return view('newpage');
    //return $_SERVER['REQUEST_METHOD'];
});
*/

Route::get('post',function () {
    return view('newpage');
})->name('homepage');

/*
Route::group(['namespace'=>'App\Http\Controllers\Backend'],function () {
    Route::get('page2/{ad?}/{soyad?}','Page2Controller@index')->where(['ad'=>'[a-z]+','soyad'=>'[A-Z]+']);

    Route::get('page3','Page3Controller@index')->name('backend.page3');
    Route::get('page4','Page4Controller@index');
    Route::get('single','SingleController');
});
*/
/*
Route::group(['namespace'=>'App\Http\Controllers\Frontend'],function () {
    Route::get('pageFrontend','PageController@index');
});
*/

Route::get('/backend',function () {
    return view('Backend.default.index');
});

Route::get('/frontend',function () {
    return view('Frontend.index');
});

/*
Route::get('page',function () {
    $data=['ad'=>'Enes','soyad'=>'CEMCİR'];
    $ad="Enes";
    $soyad="CEMCİR";
    //return view('page')->with('ad',$ad)->with('soyad',$soyad);

    return view('page',compact('data'));
});
*/

Route::group(['namespace'=>'App\Http\Controllers'],function () {
    Route::get('page','Page1Controller@index');
    Route::get('show','Page1Controller@show');
});

Route::group(['namespace'=>'App\Http\Controllers\Backend'],function () {
    Route::get('page2/{ad?}/{soyad?}','Page2Controller@index');
    Route::get('page3','Page3Controller@index')->name('backend.page3');
    Route::get('page4','Page4Controller@index');
    Route::get('single','SingleController');
    Route::get('getStudent/{id}','StudentController@Get');
});

Route::group(['namespace'=>'App\Http\Controllers\Frontend'],function () {
    Route::get('pageFrontend','PageController@index');
    Route::get('course','CourseController@index');
    Route::post('courseInsert','CourseController@courseInsert')->name('courseInsert');
    //Route::get('seferler/{id}','ExpeditionController@GetById');
    Route::get('/seferler/{deparatureCityId}/{arriveCityId}/{date}','ExpeditionController@GetAll');
});





