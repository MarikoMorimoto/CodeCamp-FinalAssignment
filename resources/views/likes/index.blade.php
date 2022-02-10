@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>お気に入り一覧</h1>
    <p>お気に入り登録した日時が新しい順に並んでいます（降順）</p>
    <ul>
        @forelse($like_items as $item)
            <li class="item">
                <p>お気に入り登録した時刻: {{ $item->pivot->created_at }}</p>
                <a href="{{ route('items.show', $item->id) }}">
                    <div class="item_img">
                        <img src="{{ \Storage::url($item->image) }}">
                    </div>
                </a>
                @if ($purchased_list->contains('item_id', $item->id))
                    <p class="soldout">売り切れ</p>
                @else
                    <p class="onsale">販売中</p>
                @endif
                <p>{{ $item->description }}</p>
                <div>
                    商品名: {{ $item->name }}  価格:{{ $item->price }}円
                </div>
                <div>
                    カテゴリ: {{ $item->category->name }} 出品時刻: {{ $item->created_at }}
                </div>
            </li>
        @empty
            <p>お気に入り登録した商品はありません</p>
        @endforelse
    </ul>
    {{ $like_items->links() }}
@endsection