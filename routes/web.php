<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('SwitchLang/{lang}',function($lang){
    session()->put('Lang',$lang);
    app()->setLocale($lang);
    // if (auth()->check()) {
    //     $user = App\Models\User::find(auth()->user()->id)->update(['language'=>$lang]);
    // }
	return Redirect::back();
});

Auth::routes();
Route::get('admin/auth/login','admin\AdminLoginController@login')->name('admin.login');
Route::get('publisher/auth/login','publishers\PublisherLoginController@login')->name('publisher.login');
Route::get('AdminPanel/changeTheme','admin\AdminPanelController@changeTheme')->name('changeTheme');
