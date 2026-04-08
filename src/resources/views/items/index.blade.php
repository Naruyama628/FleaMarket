@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/layouts/card.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="tab-menu">
    @if($tab === 'mylist')
        <a href="/" class="tab-menu__recommended ">
            おすすめ
        </a>

        <a href="/?tab=mylist" class="tab-menu__myList tab-menu__myList--red">
            マイリスト
        </a>
    @else
        <a href="/" class="tab-menu__recommended tab-menu__recommended--red">
            おすすめ
        </a>

        <a href="/?tab=mylist" class="tab-menu__myList">
            マイリスト
        </a>
    @endif
</div>

<section class="item-list">
    @foreach($items as $item)
        @include('layouts.product-card')
    @endforeach
</section>
@endsection

