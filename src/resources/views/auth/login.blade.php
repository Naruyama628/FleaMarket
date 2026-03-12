@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
<div class="main-header">
    <h2 class="main-header__title">ログイン</h2>
</div>

<!-- 後でけす エラー表示 -->
@foreach ($errors->all() as $error)
  <li>{{$error}}</li>
@endforeach

<form action="/login" method="post" class="login-form">
    @csrf
    <div class="login-form__item">
        <label for="email" class="login-form__label">メールアドレス</label>
        <input type="email" class="login-form__input" id="email" name="email">
    </div>

    <div class="login-form__item">
        <label for="password" class="login-form__label">パスワード</label>
        <input type="password" class="login-form__input" id="password" name="password">
    </div>

    <div class="login-form__item">
        <button class="login-form__button" type="submit">ログインする</button>
    </div>
</form>



<a href="/register" class="">aa</a>
@endsection

