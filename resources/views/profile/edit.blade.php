@extends('layouts.logged_in')

@section('title', $title)

@section('content')
    <h1>プロフィール編集</h1>
    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')
        <div>
            <label>
                名前:
                <input type="text" name="name" value="{{ Auth::user()->name }}">
            </label>
        </div>
        <div>
            <label>
                プロフィール:<br>
                <textarea name="profile" cols="50" rows="10">{{ Auth::user()->profile }}</textarea>
            </label>
        </div>
        <input type="submit" value="更新">
    </form>


@endsection