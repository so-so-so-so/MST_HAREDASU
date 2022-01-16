<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Reserve;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReserveController extends Controller
{
  //予約
  public function reserve(Request $request)
  {
    DB::beginTransaction();
    try {
      $cost = str_replace(',', '', $request['cost']);

      //ドローン数計算
      $drone = 0;
      if ($request['area'] == 1000) {
        $drone = 700;
      };
      if ($request['area'] == 750) {
        $drone = 500;
      };
      if ($request['area'] == 500) {
        $drone = 350;
      };
      if ($request['area'] == 300) {
        $drone = 200;
      };
      if ($request['area'] == 150) {
        $drone = 100;
      };
      // ログインユーザー取得
      $user = auth()->user();
      //useridの取得
      $uid = Auth::id();
      //DBに送信
      $params = Reserve::insert([
        'user_id' => Auth::id(),
        'latitude' => $request['latlng']['lat'],
        'longitude' => $request['latlng']['lng'],
        'address' => $request['address'],
        'date' => $request['date'],
        'start_time' => $request['start_time'],
        'end_time' => $request['end_time'],
        'area' => $request['area'],
        'drone' => $drone,
        'cost' => $cost,
        'status' => '0',
      ]);
      DB::commit();
      //return
      return $params;
    } catch (\Exception $e) {
      DB::rollback();
      return $msg = "失敗";
      if (strpos($e, 'has already been used') !== false) {
        return $msg = "失敗";
      }
    }
  }
  //予約ページリロード時に予約取得
  public function reserve_page()
  {
    //本日の日付の取得
    $toDay = now()->format('Y-m-d');
    //日付に応じたデータの取得
    $reserves = Reserve::where('date',  $toDay)->get();
    //returnで返す
    return  $reserves;
  }
  //日付選択時に予約取得
  public function reserve_date(Request $request)
  {
    $date = $request->day;
    //日付データに基づいたデータの取得
    $reserves = Reserve::where('date',  $date)->get();
    //returnで返す
    return $reserves;
  }
  //個人の予約履歴
  public function user_reserves()
  {
    //useridの取得
    $user = Auth::user();
    //useridに基づいた予約データの取得
    $user_reserves = $user->reserves()->get();
    //returnで返す
    return $user_reserves;
  }
  //予約の削除
  public function reserve_delete(Request $request)
  {
    $reserveId = Reserve::select('id')->where('id', $request->id)->value("id");
    $reserve = Reserve::find($reserveId);
    $reserve->delete();
    $result = true;
    return $result;
  }
}
