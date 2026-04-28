@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/addresses/edit.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="main-header">
    <h2 class="main-header__title">住所の変更</h2>
</div>

<form action="/purchase/address" method="post" class="address-edit-form">
    @csrf

    <input type="hidden" class="address-edit-form__hidden-input" name="item_id" value="{{ $item_id }}">

    <div class="address-edit-form__item">
        <label for="postal_code" class="address-edit-form__label">郵便番号</label>
        <input type="text" class="address-edit-form__input" id="postal_code" name="postal_code" value="{{ old('postal_code') }}">
        @error('postal_code')
            <p class="address-edit-form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="address-edit-form__item">
        <label for="address" class="address-edit-form__label">住所</label>
        <input type="text" class="address-edit-form__input" id="address" name="address" value="{{ old('address') }}">
        @error('address')
            <p class="address-edit-form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="address-edit-form__item">
        <label for="building" class="address-edit-form__label">建物名</label>
        <input type="text" class="address-edit-form__input" id="building" name="building" value="{{ old('building') }}">
    </div>

    <div class="address-edit-form__item">
        <button class="address-edit-form__button" type="submit">更新する</button>
    </div>
</form>
@endsection

