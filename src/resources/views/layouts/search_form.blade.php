@section('search')
<form action="" class="search-form">
    @csrf
    <input type="text" class="search-form__input" placeholder="何をお探しですか？">
</form>
@endsection