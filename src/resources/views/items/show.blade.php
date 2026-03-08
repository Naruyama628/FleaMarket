@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="item-detail">
    <div class="item-detail__left">
        <img src="" alt="" class="item-detail__img">
    </div>

    <div class="item-detail__right">
        <div class="item-detail__name">
            商品名がここに入る
        </div>

        <div class="item-detail__brand">
            ブランド
        </div>

        <div class="item-detail__price">
            ￥
        </div>

        <div class="item-detail__icon">
            <div class="item-detail__icon--heart"></div>
            <div class="item-detail__icon--comment"></div>
        </div>

        <form action="" class="item-detail__form">
            <button class="item-detail__form--submit">
                購入手続きへ
            </button>
        </form>

        <div class="item-description">
            <div class="item-description__title">
                商品説明
            </div>

            <div class="item-description__color">
                カラー:
            </div>

            <div class="item-description__text">
                aaaaaaaaaaaaaaaaaaaaaaaa
            </div>
        </div>

        <div class="item-information">
            <div class="item-information__category">
                カテゴリー:
            </div>

            <div class="item-information__condition">
                状態:良好
            </div>
        </div>

        <div class="item-comment">
            <div class="item-comment__user">
                <img src="" alt="" class="item-comment--user-img">
                <p class="item-comment__user--name"></p>
            </div>
            <form action="" class="item-comment__form">
                <p class="item-comment__form--text">商品へのコメント</p>
                <input type="text" class="item-comment__form--input">
            </form>
        </div>
    </div>
</div>

@endsection