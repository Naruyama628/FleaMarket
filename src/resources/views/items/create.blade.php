@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/login.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="main-header">
    <h2 class="main-header__title">商品の出品</h2>
</div>

<form action="" class="create-form">
    <div class="create-form__image">
        <label for="image" class="create-form__image-label">商品画像</label>
        <input  class="create-form__image-input" type="file" id="image" name="image" accept="image/*" />
    </div>
    
    <div class="create-form__detail-header">
        <h3 class="create-form__detail-header-text">商品の詳細</h3>
    </div>

    <div class="create-form__category">
        <span class="create-form__category-span">カテゴリー</span>
        <!-- ここをforeach -->
        <div class="create-form__category-checkbox">
            <label for="image" class="create-form__category-checkbox-label">a</label>
            <input  class="create-form__category-checkbox-input" type="checkbox" id="image" name="image">
        </div>
    </div>

    <div class="create-form__condition">
        <label for="image" class="create-form__condition-label">状態</label>
        <select  class="create-form__condition-input" id="image" name="image">
            <option value="dog">良好</option>
            <option value="dog">目立った傷は汚れなし</option>
            <option value="dog">やや傷や汚れあり</option>
            <option value="dog">状態が悪い</option>
        </select>
    </div>

    <div class="create-form__description-header">
        <h3 class="create-form__description-header-text">商品名説明</h3>
    </div>

    <div class="create-form__name">
        <label for="" class="create-form__name-label">商品名</label>
        <input type="text" class="create-form__name-input">
    </div>

    <div class="create-form__brand">
        <label for="" class="create-form__brand-label">ブランド名</label>
        <input type="text" class="create-form__brand-input">
    </div>

    <div class="create-form__product-description">
        <label for="" class="create-form__product-description-label">商品の説明</label>
        <input type="text" class="create-form__product-description-input">
    </div>

    <div class="create-form__price">
        <label for="" class="create-form__price-label">販売価格</label>
        <input type="num" class="create-form__price-input">
    </div>

</form>

@endsection