@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>{{ $getuser->name }}の出品商品一覧</h1>
    <a href="{{ route('items.create') }}">新規出品</a>
    <p>出品した日時が新しい順に並んでいます（降順）</p>
    <ul>
        @forelse($items as $item)
            <li class="item">
                <a href="{{ route('items.own', $item->id) }}">
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
                
                <div>
                    [<a href="{{ route('items.edit', $item) }}">編集</a>]
                    [<a href="{{ route('items.edit_image', $item) }}">画像を変更</a>]
                </div>
                <form method="post" class="delete" action="{{ route('items.destroy', $item) }}">
                    @csrf
                    @method('delete')
                    <input type="submit" value="削除">
                </form>
            </li>
        @empty
            <p>出品している商品はありません</p>
        @endforelse
    </ul>
    {{ $items->links() }}

@endsection