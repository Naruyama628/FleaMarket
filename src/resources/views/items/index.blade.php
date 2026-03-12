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
@include('layouts.product-card')
</section>

<a href="/create" class="">aa</a>
@endsection

