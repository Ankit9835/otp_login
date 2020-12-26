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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/verifyOTPPage', 'VerifyOtpController@showVerifyForm');
Route::post('/verifyOTP', 'VerifyOtpController@verify')->name('verify.otp');

Route::group(['middleware' => 'TwoFa'], function(){
	Route::get('/home', 'HomeController@index')->name('home');
});

