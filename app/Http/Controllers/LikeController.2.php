<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;
use App\Like;

class LikeController extends Controller
{
    // ログイン時でないと開けないアクセス制限をかける
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        // （クエリビルダ）->paginate(ページごとの件数) として、getメソッドの代わりにページネーションできる
        $like_items = \Auth::user()->likeItems()->latest()->paginate(3);
        return view('likes.index', [
            'title' => 'Market | お気に入り一覧',
            'like_items' => $like_items,
        ]);
    }
    
    public function ajax($id){
        // dd('abc');
        $user = \Auth::user();
        $item = Item::find($id);
        
        if ($item->isLikedBy($user)) {
            // いいねの取り消し where(引数1, 引数2)で 引数1 = 引数2 という意味
            $item->likes->where('user_id', $user->id)->first()->delete();
            session()->flash('success', 'いいねを取り消しました');
        } else {  // まだいいねをしていない場合 いいねを設定
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
            session()->flash('success', 'いいねしました');
        };
        return redirect('/items');
    }
}
