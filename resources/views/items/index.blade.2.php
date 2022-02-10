@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1 class="subtitle">息をするように、買おう。</h1>
    <h3>
        <a href="{{ route('items.create') }}">新規出品</a>
    </h3>
    <ul>
        @forelse($recommend_items as $item)
            <li class="item">
                <div class="item_img">
                    <img src="{{ \Storage::url($item->image) }}">
                </div>
                <p>{{ $item->description }}</p>
                <section class="like_container">
                    <div>
                        商品名: {{ $item->name }}  価格:{{ $item->price }}円
                    </div>
                    {{-- いいねの実装 --}}
                    
                    @if($item->isLikedBy($user))
                        {{-- i タグのdata- はカスタムデータ属性 いいね対象id をjQuery に伝える役割 --}}
                        <i class="fas fa-heart fa-2x like_toggle liked" data-id="{{ $item->id }}"></i>
                        <form method="post" class="like" action="{{ route('ajax.like', $item->id) }}">
                            @csrf
                            @method('patch')
                        </form>
                    @else
                        <i class="far fa-heart fa-2x like_toggle" data-id="{{ $item->id }}"></i>
                        <form method="post" class="like" action="{{ route('ajax.like', $item->id) }}">
                            @csrf
                            @method('patch')
                        </form>
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
        //$('.like_toggle').each(function(){
        /*    $(this).on('click', function(){
                $(this).toggleClass('liked');
                $(this).next().submit();
            });
        });*/
        $('.like_toggle').on('click', function() {
            $(this).toggleClass('liked');
            $(this).next().submit();
        });
        // toggleClass() 対象となる要素のclass属性の追加・削除を繰り返すことができる
    </script>

@endsection