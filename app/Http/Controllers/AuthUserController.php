<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthUserController extends Controller
{
  //
  /**
   * ログイン
   */
  public function login(Request $request)
  {
    return $request;
    $result = false;
    $message = '';
    $credentials = $request->only('email', 'password');
    if (Auth::attempt($credentials)) {
      $request->session()->regenerate();
      $result = true;
    } else {
      $message = 'EmailまたはPasswordが間違っています。';
    }
    return response()->json(['result' => $result, 'message' => $message]);
  }
  /**
   * ログアウト
   */
  public function logout(Request $request)
  {
    $result = true;
    $message = 'ログアウトしました。';
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return response()->json(['result' => $result, 'message' => $message]);
  }
  // ユーザ登録
  public function regist(Request $request)
  {
    User::create([
      'name' =>  $request->name,
      'name_kana' => $request->nameKana,
      'email' => $request->email,
      'password' => Hash::make($request->password),
      'tell' => $request->tell,
      'zip' => $request->zip,
      'address' => $request->address,
    ]);
    $result = true;
    $message = "成功";
    return response()->json(['result' => $result, 'message' => $message]);
  }
}
