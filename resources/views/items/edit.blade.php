@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>商品情報の編集</h1>
    <h2>商品追加フォーム</h2>
    <form method="post" action="{{ route('items.update', $item) }}">
        @csrf
        @method('patch')
        <div>
            <label>
                商品名:
                <input type="text" name="name" value="{{ $item->name }}">
            </label>
        </div>
        
        <div>
            <label>
                商品説明:<br>
                <textarea name="description" cols="50" rows="10">{{ $item->description }}</textarea>
            </label>
        </div>
        
        <div>
            <label>
                価格:
                <input type="text" name="price" value="{{ $item->price }}">
            </label>
        </div>
        
        <div>
            <label>
                カテゴリー:
                <select name="category_id">
                    @forelse($categories as $category)
                        @if($category->id === $item->category_id)
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
                </select>
            </label>
        </div>
        
        <input type="submit" value="更新">
    </form>
@endsection