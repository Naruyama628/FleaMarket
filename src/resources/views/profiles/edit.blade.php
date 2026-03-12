@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="profile-edit-header">
    <h2 class="profile-edit-header__title">プロフィール設定</h2>
</div>

<div class="profile">
    <div class="profile__avatar">
        <img src="" alt="" class="profile__avatar-image">
    </div>

    <p class="profile__name"></p>

    <form action="" class="profile__image-form">
        <input  class="profile__image-input" type="file" id="image" name="image" accept="image/*" />
    </form>
</div>

<form action="" class="profile-edit-form">
    <div class="profile-edit-form__group">
        <label for="" class="profile-edit-form__label">ユーザー名</label>
        <input type="text" class="profile-edit-form__input">
    </div>

    <div class="profile-edit-form__group">
        <label for="" class="profile-edit-form__label">郵便番号</label>
        <input type="text" class="profile-edit-form__input">
    </div>

    <div class="profile-edit-form__group">
        <label for="" class="profile-edit-form__label">住所</label>
        <input type="text" class="profile-edit-form__input">
    </div>

    <div class="profile-edit-form__group">
        <label for="" class="profile-edit-form__label">建物名</label>
        <input type="text" class="profile-edit-form__input">
    </div>
</form>

@endsection