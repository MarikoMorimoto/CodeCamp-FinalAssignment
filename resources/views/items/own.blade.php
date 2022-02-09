@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>商品詳細</h1>
    <h5 class="bold">商品名</h5>
    <p>{{ $detail_item->name }}</p>
    <h5 class="bold">商品画像</h5>
    <img src="{{ \Storage::url($detail_item->image) }}">
    <h5 class="bold">カテゴリ</h5>
    <p>{{ $detail_item->category->name }}</p>
    <h5 class="bold">価格</h5>
    <p>{{ $detail_item->price }}</p>
    <h5 class="bold">説明</h5>
    <p>{{ $detail_item->description }}</p>
    <a href="{{ route('users.exhibitions', $user) }}">
        {{ $user->name }}の出品商品一覧に戻る
    </a>
@endsection