<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>mail</title>
  <style>
    .btn_item {
      display: inline-block;
      padding: 10px 20px;
      text-decoration: none;
      background: rgb(228, 226, 223);
      color: #fff;
      /* border-radius: 5px; デザインによる */
    }

    .btn_item:hover {
      transition: all .2s linear;
      background: rgb(249, 194, 112);
    }
  </style>
</head>

<body>
  <h1>新規登録のご案内</h1>
  <p>この度は、「ハレダス」にお申し込み頂きまして</p>
  <p>誠にありがとうございます。</p>
  <p>下記ボタンを押しアカウントの本登録を完了させて下さい。</p>
  <p>{{url('/user_regist2?email='.$email)}}</p>
  <a href="{{url('/user_regist2?email='.$email)}}" class="btn_item">ここを押して</a>
</body>

</html>