@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="tab-menu">
    <form action="" method="" class="recommended-form">
        <button class="recommended-form__button">
            おすすめ
        </button>
    </form>

    <form action="" method="" class="myList-form">
        <button class="myList-form__button">
            マイリスト
        </button>
    </form>
</div>

<section class="item-list">
    <article class="item-card">
        <form action="/show" method="get" class="item-card__form">
            <button type="submit" class="item-card__button">
                <img src="{{ asset('img/ハートロゴ_デフォルト.png') }}" alt="商品画像" class="item-card__img">
            </button>
            <p class="item-card__name">aa</p>
        </form>
    </article>
</section>
@endsection

