@section('nav')
@auth
<form action="/logout" method="post" class="auth-form">
    @csrf
    <button type="submit" class="auth-form__button">
        ログアウト
    </button>
</form>
@endauth

@guest
<form action="/login" method="get" class="auth-form">
    @csrf
    <button type="submit" class="auth-form__button">
        ログイン
    </button>
</form>
@endguest

<form action="" method="post" class="mypage-form">
    @csrf
    <button type="submit" class="mypage-form__button">
        マイページ
    </button>
</form>

<form action="" method="post" class="sell-form">
    @csrf
    <button type="submit" class="sell-form__button">
        出品
    </button>
</form>
@endsection