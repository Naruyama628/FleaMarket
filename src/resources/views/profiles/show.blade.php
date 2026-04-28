@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profiles/show.css') }}">
<link rel="stylesheet" href="{{ asset('css/layouts/card.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')

<div class="profile">
    <div class="profile__avatar">
        <img src="{{ $user->profile?->profile_image ? asset('storage/' . $user->profile?->profile_image) : '' }}" alt="プロフィール画像" class="profile__avatar-image">
    </div>

    <div class="profile__name">
        <p class="profile__name-text">{{ $user->name }}</p>
    </div>

        <a href="/mypage/profile" class="profile__edit-link">プロフィールを編集</a>
</div>

<div class="tab-menu">
    @if($page === 'buy')
    <a href="/mypage?page=sell" class="tab-menu__sell">
        出品した商品
    </a>

    <a href="/mypage?page=buy" class="tab-menu__buy tab-menu__buy--active">
        購入した商品
    </a>
    @else
        <a href="/mypage?page=sell" class="tab-menu__sell tab-menu__sell--active">
            出品した商品
        </a>

        <a href="/mypage?page=buy" class="tab-menu__buy">
            購入した商品
        </a>
    @endif
</div>

<section class="item-list">
    @foreach($items as $item)
        @include('layouts.product-card')
    @endforeach
</section>

@endsection