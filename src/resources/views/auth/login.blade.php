@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
@endsection

@section('content')
<div class="main-header">
    <h2 class="main-header__title">ログイン</h2>
</div>

<form action="/login" method="post" class="login-form">
    @csrf
    <div class="login-form__item">
        <label for="email" class="login-form__label">メールアドレス</label>
        <input type="email" class="login-form__input" id="email" name="email">
        @error('email')
            <p class="login-form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="login-form__item">
        <label for="password" class="login-form__label">パスワード</label>
        <input type="password" class="login-form__input" id="password" name="password">
        @error('password')
            <p class="login-form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="login-form__item">
        <button class="login-form__button" type="submit">ログインする</button>
    </div>

    <div class="login-form__item login-form__item--text-center">
        <a href="/register" class="login-form__register-link">会員登録はこちら</a>
    </div>
</form>
@endsection

