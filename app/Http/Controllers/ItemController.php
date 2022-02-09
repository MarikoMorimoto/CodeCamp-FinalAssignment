<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ItemRequest;
use App\Http\Requests\ItemEditRequest;
use App\Http\Requests\ItemImageEditRequest;
use App\Http\Requests\CategorizeRequest;
use App\Services\FileUploadService;
use App\User;
use App\Item;
use App\Order;
use App\Category;

class ItemController extends Controller
{
    // ログイン時でないと開けないアクセス制限をかける
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // コレクションクラスのメソッドcontainsは、完全一致で true を返す
        // $test = collect([10, 11, 12, 13]);
        // dd($test->contains(1)); この場合返り値は false
        
        $user_id = \Auth::user()->id;
        // Itemモデルで作成したscopeRecommendはコレクションのため、クエリビルダであるpaginate()は使えない
        // recommend()の第一引数はItemモデルのメソッドscopeRecommend の第二引数に設定される
        $recommend_items = Item::recommend($user_id)->paginate(3);
        $purchased_list = DB::table('orders')->get();
        $categories = DB::table('categories')->get();
        return view('items.index', [
            'title' => 'Market | トップページ',
            'recommend_items' => $recommend_items,
            'purchased_list' => $purchased_list,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create', [
            'title' => 'Market | 商品を出品',
            'categories' => DB::table('categories')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ItemRequest $request, FileUploadService $service)
    {
        $path = $service->saveImage($request->file('image'));
        Item::create([
            'user_id' => \Auth::user()->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $path,
        ]);
        session()->flash('success', '商品を追加出品しました');
        return redirect()->route('users.exhibitions', \Auth::user()->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // $purchased_list = collect([]);
        $purchased_list = DB::table('orders')->get();
        // dd($purchased_list);
        return view('items.show', [
            'title' => 'Market | 商品詳細',
            'detail_item' => Item::find($id),
            'purchased_list' => $purchased_list,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Item::find($id);
        return view('items.edit', [
            'title' => 'Market | 商品情報の編集',
            'item' => $item,
            'categories' => DB::table('categories')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ItemEditRequest $request, $id)
    {
        $item = Item::find($id);
        $item->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);
        
        session()->flash('success', '商品情報を更新しました');
        return redirect()->route('items.own', $item->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        // 画像の削除
        \Storage::disk('public')->delete($item->image);
        
        $item->delete();
        session()->flash('success', '商品を削除しました');
        return redirect()->route('users.exhibitions', \Auth::user()->id);
    }
    
    public function itemsEditImage($id){
        $item = Item::find($id);
        return view('items.edit_image', [
            'title' => 'Market | 商品画像の編集',
            'item' => $item,
        ]);
    }
    
    public function itemsUpdateImage($id, ItemImageEditRequest $request, FileUploadservice $service){
        $item = Item::find($id);
        $path = $service->saveImage($request->file('image'));
        // 変更前の画像の削除
        \Storage::disk('public')->delete(\Storage::url($item->image));
        
        $item->update([
            'image' => $path, // ファイル名を保存
        ]);
        
        session()->flash('success', '商品画像を更新しました');
        return redirect()->route('items.own', $item->id);
    }
    
    public function confirm($id){
        return view('items.confirm', [
            'title' => 'Market | 購入確認画面',
            'confirm_item' => Item::find($id),
        ]);
    }
    
    public function finish($id){
        $user = \Auth::user();
        $item = Item::find($id);
        
        // 購入履歴テーブルに追加
        Order::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
        
        return view('items.finish', [
            'title' => 'Market | 購入完了画面',
            'purchased_item' => Item::find($id),
        ]);
        
    }
    public function own($id){
        return view('items.own', [
            'title' => 'Market | 商品詳細',
            'detail_item' => Item::find($id),
        ]);
    }
    
    // カテゴライズ用ルート
    public function categorize(CategorizeRequest $request)
    {
        $user_id = \Auth::user()->id;
        $choiced_category = Category::find($request->category_id);
        $recommend_items = Item::recommend($user_id)->where('category_id', $request->category_id)->paginate(3);
        $categories = DB::table('categories')->get();
        $purchased_list = DB::table('orders')->get();
        // dd($recommend_items);
        return view('items.categorize', [
            'title' => 'Market | トップページ',
            'recommend_items' => $recommend_items,
            'categories' => $categories,
            'purchased_list' => $purchased_list,
            'choiced_category' => $choiced_category,
        ]);
    }
}
