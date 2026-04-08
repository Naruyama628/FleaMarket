@section('search')
<form action="/search" method="get" class="search-form">
    @csrf
    
    @isset($tab)
        <input type="hidden" class="search-form___input-hidden" name="tab" value="{{ $tab }}">
    @else
        <input type="hidden" class="search-form___input-hidden" name="tab" value="recommended">
    @endisset
    

    <input type="text" class="search-form__input" name="keyword" placeholder="何をお探しですか？">
</form>
@endsection