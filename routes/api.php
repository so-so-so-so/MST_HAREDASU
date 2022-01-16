<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
//   return $request->user();
// });
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
  return $request->user();
});

//ログインログアウト登録処理
Route::post('/logout', 'AuthUserController@logout');
Route::post('/login', 'AuthUserController@login');
Route::post('/regist', 'AuthUserController@regist');
Route::post('/regist_mail', 'UsersController@regist_mail')->name('regist_mail');
Route::get('/login_check', 'UsersController@login_check');
//予約処理のroute
Route::post('/reserve_delete', 'ReserveController@reserve_delete');
Route::post('/reserve', 'ReserveController@reserve');
Route::get('/reserve_page', 'ReserveController@reserve_page');
Route::post('/reserve_date', 'ReserveController@reserve_date');
Route::get('/user_reserves', 'ReserveController@user_reserves');
//クレカのroute
// Route::get('/pay_info', 'PaymentController@pay_info');
// Route::post('/pay_regist', 'PaymentController@pay_regist');

Route::get('/whetherCode', 'GooglemapController@whetherCode');
Route::post("/whether", 'GooglemapController@whether');
