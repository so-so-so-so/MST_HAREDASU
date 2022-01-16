@extends('layouts.app')

@section('content')
<>
  <p>{{$user->email}}</p>
  <p>{{$user->password}}</p>
  <p>{{$user->first_name}}</p>
  <p>{{$user->last_name}}</p>
  <p>{{$user->first_name_kana}}</p>
  <p>{{$user->last_name_kana}}</p>
  <p>{{$user->tell}}</p>
  <p>{{$user->zip}}</p>
  <p>{{$user->address}}</p>


  {{Auth::user()->id}}
  <div>
    <form action="/regist_user_info" method="post">
      @csrf
      <div class="form-group row">
        <label for="first_name" class="col-md-4 col-form-label text-md-right">{{ __('first_name') }}</label>

        <div class="col-md-6">
          <input id="first_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name">

          @error('first_name')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="last_name" class="col-md-4 col-form-label text-md-right">{{ __('last_name') }}</label>

        <div class="col-md-6">
          <input id="last_name" type="text" class="form-control @error('first_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name">

          @error('last_name')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="first_name_kana" class="col-md-4 col-form-label text-md-right">{{ __('first_name_kana') }}</label>

        <div class="col-md-6">
          <input id="first_name_kana" type="text" class="form-control @error('first_name_kana') is-invalid @enderror" name="first_name_kana" value="{{ old('first_name_kana') }}" required autocomplete="first_name_kana">

          @error('first_name_kana')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="last_name_kana" class="col-md-4 col-form-label text-md-right">{{ __('last_name_kana') }}</label>

        <div class="col-md-6">
          <input id="last_name_kana" type="text" class="form-control @error('last_name_kana') is-invalid @enderror" name="last_name_kana" value="{{ old('last_name_kana') }}" required autocomplete="last_name_kana">

          @error('last_name_kana')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="tell" class="col-md-4 col-form-label text-md-right">{{ __('tell') }}</label>

        <div class="col-md-6">
          <input id="tell" type="text" class="form-control @error('tell') is-invalid @enderror" name="tell" value="{{ old('tell') }}" required autocomplete="tell">

          @error('tell')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="zip" class="col-md-4 col-form-label text-md-right">{{ __('zip') }}</label>

        <div class="col-md-6">
          <input id="zip" type="text" class="form-control @error('zip') is-invalid @enderror" name="zip" value="{{ old('zip') }}" required autocomplete="zip">

          @error('zip')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>

      <div class="form-group row">
        <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('address') }}</label>

        <div class="col-md-6">
          <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

          @error('address')
          <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
          </span>
          @enderror
        </div>
      </div>
      <div class="form-group row mb-0">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn btn-primary">
            {{ __('ユーザ情報登録') }}
          </button>
        </div>
      </div>
    </form>
  </div>
  <div>
    <form action="/regist_mail" method="POST">
      @csrf
      <p>メール送信</p>
      <input id="email" name="email" type="text">
      <button type="submit">送信</button>
    </form>
    <form action="/hon_regist" method="POST">
      @csrf
      <input type="text" name="email">
      <button type="submit">aaaaaaa</button>
    </form>
  </div>
  @endsection
  <div id="payment">
    <form action="/payment" method="post">
      @csrf
      <script src="https://checkout.pay.jp/" class="payjp-button" data-key="{{ config('payjp.public_key') }}" data-text="カード情報を入力" data-submit-text="カードを登録する"></script>
    </form>
    @if (!empty($cardList))
    <p>もしくは登録済みのカードで支払い</p>
    <form action="/payment" method="post">
      @csrf

      @foreach ($cardList as $card)
      <div class="card-item">
        <label>
          <input type="radio" name="payjp_card_id" value="{{ $card['id'] }}" />
          <span class="brand">{{ $card['brand'] }}</span>
          <span class="number">{{ $card['cardNumber'] }}</span>
        </label>
        <div>
          <p>名義: {{ $card['name'] }}</p>
          <p>期限: {{ $card['exp_year'] }}/{{ $card['exp_month'] }}</p>
        </div>
      </div>
      @endforeach

      <button type="submit">選択したカードで決済する</button>
    </form>
    @endif
  </div>
  @if (session('message'))
  <p>{{ session('message') }}</p>
  @endif
  @if (session('error-message'))
  <p>{{ session('error-message') }}</p>
  @endif

  <>