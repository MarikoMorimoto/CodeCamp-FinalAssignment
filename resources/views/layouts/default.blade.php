<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <title>@yield('title')</title>
        {{-- Font Awesome CDN --}}
        <link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
        {{-- bootstrap4 stylesheet --}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        {{-- 自分で設定したcss stylesheet は publicディレクトリから参照できる --}}
        <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
        {{-- jQuery CDN HTMLを記述する前（head）に書く必要がある！$ を書くために必須 --}}
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    </head>
    <body>
       @yield('header')
       
       {{-- エラーメッセージを出力 --}}
       {{-- Laravelでは、バリデーションの実施時にチェックに引っかかった値があると
       　　 自動的に$errors という変数に、エラーメッセージを準備する。
       　　 なお、この$errors はViewErrorBag型という特殊なデータ型のため
       　　 以下のように記述することで配列のように扱うことが可能。--}}
       @foreach($errors->all() as $error)
            <p class="error">{{ $error }}</p>
       @endforeach
       
       {{-- 成功メッセージを出力 --}}
       {{-- hasメソッドは、指定した名前の値が存在していればtrue そうでなければfalseを返すメソッド--}}
       @if (session()->has('success'))
            <div class="success">
                {{ session()->get('success') }}
            </div>
        @endif
        <div class="container">
            @yield('content')
        </div>
        {{-- bootstrap4 CDN (popper) boostsrap.bundle.min を読み込むならpopper はいらない --}}
        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> --}}
        
        {{-- bootstrap4 CDN --}}
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
    </body> 
</html>