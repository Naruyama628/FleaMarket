@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="main-header">
    <h2 class="main-header__title">住所の変更</h2>
</div>

<form action="/edit" method="post" class="address-edit-form">
    @csrf
    <div class="address-edit-form__item">
        <label for="postal_code" class="address-edit-form__label">郵便番号</label>
        <input type="postal_code" class="address-edit-form__input" id="postal_code" name="postal_code">
    </div>

    <div class="address-edit-form__item">
        <label for="address" class="address-edit-form__label">住所</label>
        <input type="address" class="address-edit-form__input" id="address" name="address">
    </div>

    <div class="address-edit-form__item">
        <label for="building" class="address-edit-form__label">建物名</label>
        <input type="building" class="address-edit-form__input" id="building" name="building">
    </div>

    <div class="address-edit-form__item">
        <button class="address-edit-form__button" type="submit">更新する</button>
    </div>
</form>

<a href="/register" class="">aa</a>
@endsection

