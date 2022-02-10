@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>購入確認</h1>
    <h5 class="bold">商品名</h5>
    <p>{{ $confirm_item->name }}</p>
    <h5 class="bold">商品画像</h5>
    <img src="{{ \Storage::url($confirm_item->image) }}">
    <h5 class="bold">カテゴリ</h5>
    <p>{{ $confirm_item->category->name }}</p>
    <h5 class="bold">価格</h5>
    <p>{{ $confirm_item->price }}</p>
    <h5 class="bold">説明</h5>
    <p>{{ $confirm_item->description }}</p>
    <form method="post"  action="{{ route('items.finish', $confirm_item->id) }}">
        @csrf
        <input type="submit" value="内容を確認して購入する">
    </form>
@endsection