@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items/show.css') }}">
@endsection

@include('layouts.search_form')
@include('layouts.nav')

@section('content')
<div class="item-detail">
    <div class="item-detail__left">
        <img src="{{ asset('storage/' . $item->image) }}" alt="" class="item-detail__img">
    </div>

    <div class="item-detail__right">
        <div class="item-detail__name">
            {{ $item->name }}
        </div>

        <div class="item-detail__brand">
            {{ $item->brand }}
        </div>

        <div class="item-detail__price">
            <p class="item-detail__price--label">￥</p>
            <p class="item-detail__price--num">{{ number_format($item->price) }}</p>
            <p class="item-detail__price--label">(税込み)</p>
        </div>

        <div class="item-detail__actions">
            <div class="item-detail__action item-detail__action--like">
                <form action="/like/{{$item->id}}" method="post" class="item-detail__like-form">
                    @csrf
                    <button type="submit" class="item-detail__like-button">
                        @if($item->likes->contains(auth()->id()))
                            <img src="{{ asset('img/ハートロゴ_ピンク.png') }}" alt="いいね" class="item-detail__action-icon">
                        @else
                            <img src="{{ asset('img/ハートロゴ_デフォルト.png') }}" alt="いいね" class="item-detail__action-icon">
                        @endif
                </button>
                <p class="item-detail__action--like-num">{{ $item->likes_count }}</p>
                </form>
            </div>

            <div class="item-detail__action item-detail__action--comment">
                <img src="{{ asset('img/ふきだしロゴ.png') }}" alt="コメント" class="item-detail__action-icon">
                <p class="item-detail__action--like-num">{{ $item->comments_count }}</p>
            </div>
        </div>

        <a href="/purchase/{{$item->id}}" class="item-detail__purchase-link"> 購入手続きへ</a>

        <div class="item-description">
            <div class="item-description__title">
                商品説明
            </div>

            <div class="item-description__text">
                {!! nl2br(e($item->description)) !!}
            </div>
        </div>

        <div class="item-information">
            <div class="item-information__title">
                商品の状態
            </div>
            <div class="item-information__category">
                <span class="item-information__category--label">カテゴリー</span>
                <div class="item-information__category-list">
                    @foreach($item->categories as $category)
                        <span class="item-information__category-tag">
                            {{ $category->name }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="item-information__condition">
                <span class="item-information__condition--label">                商品の状態</span>
                <div class="item-information__condition--text">
                    {{ $item->condition }}
                </div>
            </div>
        </div>

        <div class="item-comment">
            <div class="item-comment__header">
                <h2 class="item-comment__title">コメント（{{ $item->comments_count }}）</h2>
            </div>
            <div class="item-comment__list">
                @foreach($item->comments as $comment)
                <div class="item-comment__item">
                    <div class="item-comment__user">
                        <img src="{{ $comment->user->profile?->profile_image ? asset('storage/' . $comment->user->profile?->profile_image) : '' }}" alt="" class="item-comment__user-img">
                        <p class="item-comment__user--name"> {{ $comment->user->name }}</p>
                    </div>
                    <div class="item-comment__content">
                        {!! nl2br(e($comment->content)) !!}
                    </div>
                </div>
                @endforeach
            </div>
            <form action="/comment/{{ $item->id }}" method="post" class="item-comment__form">
                @csrf
                <p class="item-comment__form--title">商品へのコメント</p>

                <textarea class="item-comment__form-textarea" name="comment">{{ old('comment') }}</textarea>
                @error('content')
                    <p class="item-comment__error">{{ $message }}</p>
                @enderror

                <button type="submit" class="item-comment__form--button">
                    コメントを送信する
                </button>
            </form>
        </div>
    </div>
</div>

@endsection