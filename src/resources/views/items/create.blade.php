@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/create.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="main-header">
    <h2 class="main-header__title">商品の出品</h2>
</div>

<form action="/sell" method="post" class="create-form" enctype="multipart/form-data">
    @csrf
    <div class="create-form__image">
        <span class="create-form__image-header">商品画像</span>
        <div class="create-form__image-wrapper">
            <label for="image" class="create-form__image-label">画像を選択する</label>
            <input  class="create-form__image-input" type="file" id="image" name="image" accept="image/*" />
        </div>
    </div>

    <div class="create-form__detail-header">
        <h3 class="create-form__detail-header-text">商品の詳細</h3>
    </div>

    <div class="create-form__category">
        <span class="create-form__category-span">カテゴリー</span>
        <div class="create-form__category-list">
            @foreach ($categories as $category)
            <div class="create-form__category-checkbox">
                <input  class="create-form__category-checkbox-input" type="checkbox" id="category-{{ $category->id }}" name="category[]" value="{{ $category->id }}">

                <label for="category-{{ $category->id }}" class="create-form__category-checkbox-label">{{ $category->name }}</label>
            </div>
            @endforeach
        </div>
    </div>

    <div class="create-form__condition">
        <label for="condition" class="create-form__condition-label">状態</label>
        <select  class="create-form__condition-select" id="condition" name="condition">
            <option value="良好">良好</option>
            <option value="目立った傷は汚れなし">目立った傷は汚れなし</option>
            <option value="やや傷や汚れあり">やや傷や汚れあり</option>
            <option value="状態が悪い">状態が悪い</option>
        </select>
    </div>

    <div class="create-form__description-header">
        <h3 class="create-form__description-header-text">商品名と説明</h3>
    </div>

    <div class="create-form__item">
        <label for="name" class="create-form__item-label">商品名</label>
        <input type="text" class="create-form__item-input" id="name" name="name">
    </div>

    <div class="create-form__item">
        <label for="brand" class="create-form__item-label">ブランド名</label>
        <input type="text" class="create-form__item-input" id="brand" name="brand">
    </div>

    <div class="create-form__item">
        <label for="description" class="create-form__item-label">商品の説明</label>
        <textarea class="create-form__item-textarea" id="description" name="description"></textarea>
    </div>

    <div class="create-form__item">
        <label for="price" class="create-form__item-label">販売価格</label>
        <input type="number" class="create-form__item-input" id="price" name="price">
    </div>

    <div class="create-form__button">
        <button class="create-form__button--submit">出品する</button>
    </div>

</form>

@endsection