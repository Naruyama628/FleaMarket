@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profiles/edit.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="profile-edit-header">
    <h2 class="profile-edit-header__title">プロフィール設定</h2>
</div>

<form action="/profile/edit" method="post" class="profile-edit-form" enctype="multipart/form-data">
    @csrf
    <div class="profile">
        <div class="profile__avatar">
            <img src="{{ $user->profile?->profile_image ? asset('storage/' . $user->profile?->profile_image) : '' }}" class="profile__avatar-image">
        @error('image')
            <p class="profile-edit-form__error">{{ $message }}</p>
        @enderror
        </div>

        <label for="image" class="profile__image-button">画像を選択する</label>
        
        <input  class="profile__image-input" type="file" id="image" name="image" accept="image/*" />
    </div>

    <div class="profile-edit-form__group">
        <label for="name" class="profile-edit-form__label">ユーザー名</label>
        <input type="text" class="profile-edit-form__input" id="name" name="name" value="{{ old('name', $user->name) }}">
        @error('name')
            <p class="profile-edit-form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="profile-edit-form__group">
        <label for="postal_code" class="profile-edit-form__label">郵便番号</label>
        <input type="text" class="profile-edit-form__input" id="postal_code" name="postal_code" value="{{ old('postal_code', $user->profile?->postal_code ?? '') }}">
        @error('postal_code')
            <p class="profile-edit-form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="profile-edit-form__group">
        <label for="address" class="profile-edit-form__label">住所</label>
        <input type="text" class="profile-edit-form__input" id="address" name="address" value="{{ old('address', $user->profile?->address ?? '') }}">
        @error('address')
            <p class="profile-edit-form__error">{{ $message }}</p>
        @enderror
    </div>

    <div class="profile-edit-form__group">
        <label for="building" class="profile-edit-form__label">建物名</label>
        <input type="text" class="profile-edit-form__input"  id="building" name="building" value="{{ old('building', $user->profile?->building ?? '') }}">
    </div>

    <button type="submit" class="profile-edit-form__button">
        更新する
    </button>
</form>

@endsection