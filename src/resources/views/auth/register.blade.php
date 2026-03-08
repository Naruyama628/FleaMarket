@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@section('content')
<div class="main-header">
    <h2 class="main-header__title">会員登録</h2>
</div>

<!-- 後でけす エラー表示 -->
@foreach ($errors->all() as $error)
  <li>{{$error}}</li>
@endforeach

<form action="/register" method="post" class="login-form">
    @csrf
    <div class="login-form__item">
        <label for="name" class="login-form__label">ユーザー名</label>
        <input type="text" class="login-form__input" id="name" name="name">
    </div>

    <div class="login-form__item">
        <label for="email" class="login-form__label">メールアドレス</label>
        <input type="email" class="login-form__input" id="email" name="email">
    </div>

    <div class="login-form__item">
        <label for="password" class="login-form__label">パスワード</label>
        <input type="password" class="login-form__input" id="password" name="password">
    </div>

    <div class="login-form__item">
        <label for="password_confirmation" class="login-form__label">確認用のパスワード</label>
        <input type="password" class="login-form__input" id="password_confirmation" name="password_confirmation">
    </div>

    <div class="login-form__item">
        <button class="login-form__button" type="submit">会員登録</button>
    </div>
</form>

<a href="/login" class="">aa</a>
@endsection

