<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
  //クレカの登録
  public function pay_regist(Request $request)
  {
    if (empty($request->get('payjp-token'))) {
      abort(404);
    }

    DB::beginTransaction();

    try {
      // ログインユーザー取得
      $user = auth()->user();
      //  シークレットキーを設定
      \Payjp\Payjp::setApiKey(config('payjp.secret_key'));

      //  顧客情報登録
      $customer = \Payjp\Customer::create([
        // カード情報も合わせて登録する
        'card' => $request->get('payjp-token'),
        // 概要
        'description' => "userId: {$user->id}, userName: {$user->name}",
      ]);

      //  DBにpayjpの顧客idを登録
      $user->payjp_customer_id = $customer->id;
      $user->save();
      DB::commit();
      $msg = "成功";
      return $msg;
    } catch (\Exception $e) {
      DB::rollback();
      $msg = "失敗";
      return $msg;
    }
  }
  //クレカの変更
  // クレカ情報取得
  public function pay_info()
  {
    $userData = auth()->user();
    if (!empty($userData->payjp_customer_id)) {
      // カード一覧を取得
      \Payjp\Payjp::setApiKey(config('payjp.secret_key'));
      $cardDatas = \Payjp\Customer::retrieve($userData->payjp_customer_id)->cards->data;
      foreach ($cardDatas as $cardData) {
        $cardList[] = [
          'cardNumber' =>  "**** **** **** {$cardData->last4}",
          'brand' =>  $cardData->brand,
          'exp_year' =>  $cardData->exp_year,
          'exp_month' =>  $cardData->exp_month,
          'name' =>  $cardData->name,
          'id' => $cardData->id,
        ];
      }
    }
    return compact($cardList);
  }
}
