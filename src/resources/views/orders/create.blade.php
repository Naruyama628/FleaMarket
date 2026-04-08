@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/orders/create.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="order-create">
    <div class="order-create__left">
        <!-- 商品カード -->
        <div class="product">
            <div class="product__img-wrapper">
                <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" class="product__img">
            </div>
            <div class="product__info">
                <p class="product_name">{{ $item->name }}</p>
                <div class="product__price">
                    <p class="product__price--label">￥</p>
                    <p class="product__price--num">{{ number_format($item->price) }}</p>
                </div>
            </div>
        </div>

        <!-- 支払い方法 -->
        <form action="/purchase/{{$item->id}}" method="get" class="payment_method__form">
            <input type="hidden" 
            name="postal_code" 
            value="{{ request('postal_code', $address->postal_code ?? '') }}">

            <input type="hidden" 
            name="address" 
            value="{{ request('address', $address->address ?? '') }}">

            <input type="hidden" 
            name="building" 
            value="{{ request('building', $address->building ?? '') }}">

            <p class="payment-method__label">支払い方法</p>

            <div class="payment-method__select-wrapper">
                <select name="payment_method" id="payment_method" class="payment-method__select" placeholde="選択してください" onchange="this.form.submit()">
                    <option disabled selected>選択してください</option>
                    <option value="card" 
                    {{ request('payment_method') == 'card' ? 'selected' : '' }}>カード</option>
                    
                    <option value="konbini" 
                    {{ request('payment_method') == 'konbini' ? 'selected' : '' }}>コンビニ支払い</option>
                </select>
            </div>
        </form>

        <!-- 配送先 -->
        <div class="shipping-address">
            <div class="shipping-address__header">
                <p class="shipping-address__title">配送先</p>
                <a href="/purchase/address/{{ $item->id }}" class="shipping-address__edit-link">変更する</a>
            </div>

            <div class="shipping-address__info">
                <p class="shipping-address__postal-code">〒 {{ request('postal_code', $address->postal_code)}}</p>
                <div class="shipping-address__address">
                    <p>{{ request('address', $address->address) }}</p>
                    <p>{{ request('building', $address->building) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="order-create__right">
        <div class="order-summary">
            <div class="order-summary__price">
                <p class="order-summary__label">商品代金</p>
                <p class="order-summary__value">￥ {{ number_format($item->price) }}</p>
            </div>

            @php
            $labels = [
                'card' => 'カード',
                'konbini' => 'コンビニ支払い',
            ];
            @endphp

            <div class="order-summary__payment-method">
                <p class="order-summary__label">支払方法</p>
                <p class="order-summary__value">{{ $labels[request('payment_method')] ?? '選択してください' }}</p>
            </div>
        </div>

        <form action="{{ route('checkout.create', ['item' => $item->id]) }}" method="post" class="summary-form">
            @csrf
            <input type="hidden" 
            class="summary-form__hidden-input" 
            name="payment_method" 
            value="{{request('payment_method')}}">

            <input type="hidden" 
            class="summary-form__hidden-input" 
            name="postal_code" 
            value="{{ request('postal_code', $address->postal_code) }}">

            <input type="hidden" 
            class="summary-form__hidden-input" 
            name="address" 
            value="{{ request('address', $address->address) }}">
            
            <input type="hidden" 
            class="summary-form__hidden-input" 
            name="building" 
            value="{{ request('building', $address->building) }}">
            <button class="summary-form__button">購入する</button>
        </form>
    </div>
</div>
@endsection