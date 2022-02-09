@extends('layouts.default')

@section('header')
<header>
{{-- App/Providers/AppServiceProvider.php の boot() の中に追記することで
    view全画面に共通の変数 $user = Auth::user() を渡している--}}
    <ul class="header_nav">
        <li>
            <a href="{{ route('items.index') }}">
                Market
            </a>
        </li>
        <li>
            <p>こんにちは、{{ $user->name }}さん！</p>
        </li>
        <li>
            <a href="{{ route('users.index') }}">
                プロフィール
            </a>
        </li>
        <li>
            <a href="{{ route('likes.index') }}">
                お気に入り一覧
            </a>
        </li>
        <li>
            <a href="{{ route('users.exhibitions', $user->id) }}">
                商品出品一覧
            </a>
        </li>
        <li>
            <form method="post" action="{{ route('logout') }}">
                @csrf
                <input type="submit" value="ログアウト">
            </form>
        </li>
    </ul>

</header>
@endsection