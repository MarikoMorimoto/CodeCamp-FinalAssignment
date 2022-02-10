@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>商品を出品</h1>
    <h2>商品追加フォーム</h2>
    <form
        method="post"
        action="{{ route('items.store') }}"
        enctype="multipart/form-data"
    >
        @csrf
        <div>
            <label>
                商品名:
                {{-- old()という関数を使えばエラーの際に入力した値がクリアされない --}}
                <input type="text" name="name" value="{{ old ('name') }}">
            </label>
        </div>
        
        <div>
            <label>
                商品説明:<br>
                <textarea name="description" cols="50" rows="10">{{ old('description') }}</textarea>
            </label>
        </div>
        {{-- 20/1000 のように文字数を反映させる 半角/全角 指定するとユーザーから見やすい --}}
        
        <div>
            <label>
                価格:
                <input type="text" name="price" value="{{ old('price') }}">
            </label>
        </div>
        
        <div>
            <label>
                カテゴリー:
                <select name="category_id">
                    <option value="">選択してください</option>
                    @forelse($categories as $category)
                        <option value={{ $category->id }}>
                            {{ $category->name }}
                        </option>
                    @empty
                        カテゴリーは未設定です
                    @endforelse
                </select>
            </label>
        </div>
        
        <div>
            <label>
                画像を選択:
                <input type="file" name="image">
            </label>
        </div>
        <input type="submit" value="出品">
    </form>


@endsection