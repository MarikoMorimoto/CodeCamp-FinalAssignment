@extends('layouts.logged_in')

@section('title', $title)
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <h1 class="subtitle">息をするように、買おう。</h1>
    <h3>
        <a href="{{ route('items.create') }}">新規出品</a>
    </h3>
    @forelse($recommend_items as $item)
        <div class="item">
            <div class="item_img">
                <img src="{{ \Storage::url($item->image) }}">
                {{ $item->description }}
            </div>
            <p>
                商品名: {{ $item->name }}  価格:{{ $item->price }}円 
                {{-- いいねの実装 --}}
                @if($item->isLikedBy($user))
                    <span class="likes">
                        {{-- i タグのdata- はカスタムデータ属性 いいね対象id をjQuery に伝える役割 --}}
                        <i class="fas fa-heart fa-2x like_toggle liked" data-id="{{ $item->id }}"></i>
                    </span>
                @else
                    <span class="likes">
                        <i class="far fa-heart fa-2x like_toggle" data-id="{{ $item->id }}"></i>
                    </span>
                @endif
            </p>
            <p>カテゴリ: {{ $item->category->name }} 出品時刻: {{ $item->created_at }}</p>
        </div>
    @empty
        <p>出品されている商品はありません</p>
    @endforelse
    
    <script>
    /* global $ */
        $('.like_toggle').on('click', function(){
            let likedItemId = $(this).data('id');
            console.log(likedItemId);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '/ajax/like',
                method: 'POST',
                data: {
                    'item_id': likedItemId
                },
            }).done((res) => {
                $(this).toggleClass('liked');
            }).fail((res) => {
                alert('エラーです');
            });
        });
        // toggleClass() 対象となる要素のclass属性の追加・削除を繰り返すことができる
    </script>

@endsection