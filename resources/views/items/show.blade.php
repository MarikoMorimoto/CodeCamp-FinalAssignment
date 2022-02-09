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
    @if ($purchased_list->contains('item_id', $detail_item->id))
        <p class="soldout">この商品は売り切れています。</p>
        <a href="{{ route('items.index') }}">トップに戻る</a>
    @else
        <form method="post" action="{{ route('items.confirm', $detail_item->id) }}">
            @csrf
            <input type="submit" value="購入する">
        </form>
    @endif
    
@endsection