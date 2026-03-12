@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="order-create">
    <div class="order-create__left">
        <!-- 商品カード -->
        <div class="product-card">
            <div class="product-card__img">
                <img src="" alt="商品画像">
            </div>
            <div class="product-card__info">
                <p class="product-card__name">商品名</p>
                <p class="product-card__price">47000</p>
            </div>
        </div>

        <!-- 支払い方法 -->
        <form action="" class="payment-method">
            <label for="" class="payment-method__label">支払方法</label>

            <select name="" id="" class="payment-method__select">
                <option>選択してください</option>
                <option>選択してください1</option>
            </select>
        </form>

        <!-- 配送先 -->
        <div class="shipping-address">
            <div class="shipping-address__header">
                <p class="shipping-address__title">配送先</p>
                <form action="" class="shipping-address__edit">
                    <div class="shipping-address__edit-button">
                        <button class="shipping-address__edit-button--submit">変更する</button>
                    </div>
                </form>
            </div>

            <div class="shipping-address__info">
                <p class="shipping-address__post-code">XXX-YYY</p>
                <p class="shipping-address__address">ここは住所と</p>
                <p class="shipping-address__building">建物が入ります</p>
            </div>
        </div>
    </div>

    <div class="order-create__left">
        <form action="" class="order">
            <div class="order-summary">
                <div class="order-summary__price">
                    <p class="order-summary__label">商品代金</p>
                    <p class="order-summary__value"></p>
                </div>

                <div class="order-summary__payment-method">
                    <p class="order-summary__label">支払方法</p>
                    <p class="order-summary__value"></p>
                </div>
            </div>

            <div class="order__button">
                <button class="order__button--submit">購入する</button>
            </div>
        </form>
    </div>
</div>
@endsection