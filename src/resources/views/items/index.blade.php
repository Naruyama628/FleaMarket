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
        <a href="/?keyword={{request('keyword')}}" class="tab-menu__recommended ">
            おすすめ
        </a>

        <a href="/?tab=mylist&keyword={{request('keyword')}}" class="tab-menu__mylist tab-menu__mylist--active">
            マイリスト
        </a>
    @else
        <a href="?keyword={{request('keyword')}}" class="tab-menu__recommended tab-menu__recommended--active">
            おすすめ
        </a>

        <a href="/?tab=mylist&keyword={{request('keyword')}}" class="tab-menu__mylist">
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

