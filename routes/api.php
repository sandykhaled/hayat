<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\PlacesController;
use App\Http\Controllers\api\SettingController;
use App\Http\Controllers\api\ContactUsController;
use App\Http\Controllers\api\WebServicesController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/webservices', [WebServicesController::class, 'webservices']);

Route::group(['prefix'=>'results'], function(){
    Route::get('/',[App\Http\Controllers\api\ResutlsController::class, 'index']);
    Route::get('/{id}',[App\Http\Controllers\api\ResutlsController::class, 'show']);
});

Route::group(['prefix'=>'doctors'], function(){
    Route::get('/',[App\Http\Controllers\api\DoctorController::class, 'index']);
    Route::get('/{id}',[App\Http\Controllers\api\DoctorController::class, 'show']);
});

Route::get('/places', [PlacesController::class, 'places']);


Route::group(['prefix'=>'blogs'], function(){
    Route::get('/',[App\Http\Controllers\api\BlogController::class, 'index']);
    Route::get('/{id}',[App\Http\Controllers\api\BlogController::class, 'show']);
});

Route::get('/settings', [SettingController::class, 'index']);

    Route::post('/sendContact ', [ContactUsController::class, 'sendContactMessage']);

