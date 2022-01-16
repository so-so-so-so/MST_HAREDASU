<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Auth::routes();
// middlewareで遷移先の制限
Route::get('/home', 'HomeController@index')->name('home');
// Route::group(['middleware' => 'auth'], function () {
//   Route::get('/user_info', 'UsersController@user_info')->name('user_info');
//   Route::post('/regist_user_info', 'UsersController@regist_user_info')->name('regist_user_info');
//   //payjp
//   Route::post('/payment', 'PaymentController@payment');
//   Route::post('/regist_mail', 'UsersController@regist_mail')->name('regist_mail');
// });

Route::get('/vue', function () {
  return view('app');
});
Route::get('/', function () {
  return view('welcome');
});

Route::get('/{any}', function () {
  return view('welcome');
})->where('any', '.*');

Route::get('/reserve_page', 'ReserveController@reserve_page');
Route::post('/api', 'GooglemapController@index');
Route::get('/hon_regist', 'UsersController@hon_regist')->name('hon_regist');
