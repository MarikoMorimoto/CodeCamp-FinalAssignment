@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>商品画像の変更</h1>
    <h2>現在の画像</h2>
        <img src="{{ \Storage::url($item->image) }}">
    <form
        method="post"
        action="{{ route('items.update_image', $item) }}"
        enctype="multipart/form-data"
    >
        @csrf
        @method('patch')
        <div>
            <label>
                画像を選択:
                <input type="file" name="image">
            </label>
        </div>
        <input type="submit" value="更新">
    </form>
@endsection