<article class="item-card">
    <a href="/item/{{ $item->id }}" class="item-card__link">
        <img src="{{ asset('storage/' . $item->image) }}" alt="商品画像" class="item-card__img">
        <p class="item-card__name">{{ $item->name }}</p>
        @if($item->is_sold)
           <p class="item-card__sold">Sold</p>
        @endif
    </a>
</article>