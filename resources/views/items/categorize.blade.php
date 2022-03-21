@extends('layouts.logged_in')

@section('title', $title)
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <h1 class="subtitle">息をするように、買おう。</h1>
    <h3>
        <a href="{{ route('items.create') }}">新規出品</a>
    </h3>
    <p>自分以外のユーザーが出品した商品が、出品日時の新しい順に並んでいます（降順）。</p>
    <form method="post" action="{{ route('items.categorize') }}">
        @csrf
        カテゴリー別に表示する:
        <select name="category_id">
            @forelse($categories as $category)
                @if($category->id === $choiced_category->id)
                    <option value="{{ $category->id }}" selected>
                        {{ $category->name }}
                    </option>
                @else
                    <option value="{{ $category->id }}">
                        {{ $category->name }}
                    </option>
                @endif
            @empty
                カテゴリーは未設定です
            @endforelse
            <input type="submit" value="更新">
            選択中のカテゴリー: {{ $choiced_category->name }}    
    </form>
    <a href="{{ route('items.index') }}">カテゴリー選択をリセットして表示</a>
    <ul>
        @forelse($recommend_items as $item)
            <li class="item">
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
                <section class="like_container">
                    <div>
                        商品名: {{ $item->name }}  価格:{{ $item->price }}円
                    </div>
                    {{-- いいねの実装 --}}
                    
                    @if($item->isLikedBy($user))
                        {{-- i タグのdata- はカスタムデータ属性 いいね対象id をjQuery に伝える役割 --}}
                        <i class="fas fa-heart fa-2x like_toggle liked" data-id="{{ $item->id }}"></i>
                    @else
                        <i class="far fa-heart fa-2x like_toggle" data-id="{{ $item->id }}"></i>
                    @endif
                </section>
                <div>
                    カテゴリ: {{ $item->category->name }} 出品時刻: {{ $item->created_at }}
                </div>
            </li>
        @empty
            <li>出品されている商品はありません</li>
        @endforelse
    <ul>
    {{-- ページネーション --}}
    {{ $recommend_items->links() }}
    
    <script>
    {{-- 注意 アロー関数と$(this) の組み合わせると 挙動がおかしくなる場合あり --}}
        /* $('.like_toggle').on('click', function() {
            $(this).toggleClass('liked');
            $(this).next().submit();
        });
        */
        $('.like_toggle').on('click', function(){
            let clicked_like = $(this);
            let likedItemId = $(clicked_like).data('id');
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
            }).done(function(res){
                $(clicked_like).toggleClass('liked far fas');
            }).fail(function(){
                alert('エラーです');
            });
        });
        // toggleClass() 対象となる要素のclass属性の追加・削除を繰り返すことができる
    </script>

@endsection