<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Item;
use App\Like;
use App\Http\Requests\AjaxLikeRequest;

class LikeController extends Controller
{
    // ログイン時でないと開けないアクセス制限をかける
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(){
        // （クエリビルダ）->paginate(ページごとの件数) として、getメソッドの代わりにページネーションできる
        $like_items = \Auth::user()->likeItems()->paginate(3);
        $purchased_list = DB::table('orders')->get();
        return view('likes.index', [
            'title' => 'Market | お気に入り一覧',
            'like_items' => $like_items,
            'purchased_list' => $purchased_list,
        ]);
    }
    
    public function ajax(AjaxLikeRequest $request){
        // dd('abc');  // ajaxの場合はdd() でのデバッグは使えない！処理が止まるだけ
        $user = \Auth::user();
        $item = Item::find($request->item_id);
        
        if ($item->isLikedBy($user)) {
            // いいねの取り消し where(引数1, 引数2)で 引数1 = 引数2 という意味
            $item->likes->where('user_id', $user->id)->first()->delete();
            // 非同期通信だと、次に遷移したページでflashが表示されてしまうためコメントアウト
            // session()->flash('success', 'いいねを取り消しました');
        } else {  // まだいいねをしていない場合 いいねを設定
            Like::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
            ]);
            // session()->flash('success', 'いいねしました');
        };
    }
}
