<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Order;
use App\Item;

class UserController extends Controller
{
    public function index(){
        // dd(Order::find(\Auth::user()->id));
        $user = \Auth::user();
        // $user_order = Order::find(\Auth::user());
        // orders テーブルに載っている 自分が購入した商品を取得
        $user_purchased_items = $user->orderedItems()->paginate(10);
        // dd($user_purchased_items);
        return view('users.index', [
            'title' => 'Market | プロフィール',
            'number_of_items' => \Auth::user()->items->count(),
            'purchased_items' => $user_purchased_items,
        ]);
        
    }
    
    public function exhibitions($id){
        // 全view に共通で渡している変数 $user と区別するために
        // $user ではなく $getuser と定義
        $getuser = User::find($id);
        $items = User::find($id)->items()->latest()->paginate(3);
        $purchased_list = DB::table('orders')->get();
        return view('users.exhibitions', [
            'title' => 'Market | ' . $getuser->name . 'の出品商品一覧',
            'items' => $items,
            'getuser' => $getuser,
            'purchased_list' => $purchased_list,
        ]);
    }
}
