@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/auth.css') }}">
@endsection

@section('content')
<div class="main-header">
    <h2 class="main-header__title">会員登録</h2>
</div>

<form action="/register" method="post" class="register-form" novalidate>
    @csrf
    <div class="register-form__item">
        <label for="name" class="register-form__label">ユーザー名</label>
        <input type="text" class="register-form__input" id="name" name="name" value="{{ old('name') }}">
        @error('name')
            <p class="register-form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="register-form__item">
        <label for="email" class="register-form__label">メールアドレス</label>
        <input type="email" class="register-form__input" id="email" name="email" value="{{ old('email') }}">
        @error('email')
            <p class="register-form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="register-form__item">
        <label for="password" class="register-form__label">パスワード</label>
        <input type="password" class="register-form__input" id="password" name="password">
        @error('password')
            <p class="register-form__error">{{ $message }}</p>
        @enderror
        
    </div>

    <div class="register-form__item">
        <label for="password_confirmation" class="register-form__label">確認用のパスワード</label>
        <input type="password" class="register-form__input" id="password_confirmation" name="password_confirmation">
        @error('password_confirmation')
            <p class="register-form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="register-form__item">
        <button class="register-form__button" type="submit">会員登録</button>
    </div>

    <div class="register-form__item register-form__item--text-center">
        <a href="/login" class="register-form__login-link">ログインはこちら</a>
    </div>
</form>
@endsection

