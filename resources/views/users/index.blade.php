@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>プロフィール</h1>
    @if($user->image !== '')
        <img src="{{ \Storage::url($user->image) }}">
    @else
        <img src="{{ asset('images/icon_no_image.png') }}">
    @endif
    <a href="{{ route('profile.edit_image') }}">画像を変更</a>
    <p>
        {{ $user->name }}さん <a href="{{ route('profile.edit') }}">プロフィール編集</a>
    </p>
    @if($user->profile !== '')
        <p>{{ $user->profile }}</p>
    @else
        <p>自己紹介文が設定されていません</p>
    @endif
    
    <p>出品数: {{ $number_of_items }}</p>
    
    <h2>購入履歴</h2>
    <ul>
        @forelse($purchased_items as $item)
            <li>
                <a href="{{ route('items.show', $item->id) }}">
                    {{ $item->name }}
                </a>
                : {{ $item->price }}円 出品者: {{ $item->user->name }}さん 
            </li>
        @empty
            購入した商品がありません
        @endforelse
    </ul>

@endsection