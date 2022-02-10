<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use App\Item;
use Illuminate\Support\Facades\DB;

// ->middleware('auth')により、未ログイン時はログイン画面へリダイレクト
Route::get('/', function () {
    return view('items.index',[
        'title' => 'Market | トップページ',
        'recommend_items' => Item::recommend(\Auth::user()->id)->paginate(3),
        'purchased_list' => DB::table('orders')->get(),
        'categories' => DB::table('categories')->get(),
    ]);
})->middleware('auth');

Auth::routes();


Route::resource('items', 'ItemController');

Route::get('/items/{item}/edit_image', 'ItemController@itemsEditImage')->name('items.edit_image');

Route::patch('/items/{item}/edit_image', 'ItemController@itemsUpdateImage')->name('items.update_image');

Route::post('/items/{item}/confirm', 'ItemController@confirm')->name('items.confirm');

Route::post('/items/{item}/finish', 'ItemController@finish')->name('items.finish');
// 自分自身のアイテム表示用ルート
Route::get('/items/own/{item}', 'ItemController@own')->name('items.own');
// カテゴライズ用ルート
Route::post('/items/categorize', 'ItemController@categorize')->name('items.categorize');


Route::resource('likes', 'LikeController')->only([
    'index']);
// いいねデータ追加用
Route::post('/ajax/like', 'LikeController@ajax')->name('ajax.like');


Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');

Route::patch('/profile', 'ProfileController@update')->name('profile.update');

Route::get('/profile/edit_image', 'ProfileController@editImage')->name('profile.edit_image');

Route::patch('/profile/edit_image', 'ProfileController@updateImage')->name('profile.update_image');

// idex はログインユーザー、show はログインユーザー以外のプロフィール
Route::resource('users', 'UserController')->only([
    'index', 'show']);
// 出品商品一覧
Route::get('/users/{user}/exhibitions', 'UserController@exhibitions')->name('users.exhibitions');