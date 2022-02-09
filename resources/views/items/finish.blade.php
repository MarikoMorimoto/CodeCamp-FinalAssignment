@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>ご購入ありがとうございました。</h1>
    <h5 class="bold">商品名</h5>
    <p>{{ $purchased_item->name }}</p>
    <h5 class="bold">商品画像</h5>
    <img src="{{ \Storage::url($purchased_item->image) }}">
    <h5 class="bold">カテゴリ</h5>
    <p>{{ $purchased_item->category->name }}</p>
    <h5 class="bold">価格</h5>
    <p>{{ $purchased_item->price }}</p>
    <h5 class="bold">説明</h5>
    <p>{{ $purchased_item->description }}</p>
    <a href="{{ route('items.index') }}">トップに戻る</a>
@endsection