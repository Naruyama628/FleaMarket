@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')

<div class="profile">
    <div class="profile__avatar">
        <img src="" alt="" class="profile__avatar-image">
    </div>

    <p class="profile__name-text"></p>

    <a href="" class="profile__edit">プロフィールを編集</a>
</div>

<div class="tab-menu">
    <form action="" method="" class="tab-menu__form">
        <button class="tab-menu__form--button">
            出品した商品
        </button>
    </form>

    <form action="" method="" class="tab-menu__form">
        <button class="tab-menu__form__button">
            購入した商品
        </button>
    </form>
</div>

<section class="item-list">
    @include('layouts.product-card')
</section>

@endsection