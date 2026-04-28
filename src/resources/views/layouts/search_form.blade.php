@section('search')
<form action="/search" method="get" class="search-form">
    @isset($tab)
        <input type="hidden" name="tab" value="{{ $tab }}">
    @else
        <input type="hidden" name="tab" value="recommended">
    @endisset
    
    <input type="text" class="search-form__input" name="keyword" placeholder="何をお探しですか？" value="{{ request('keyword') }}">
</form>
@endsection