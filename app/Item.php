<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'category_id',
        'image',
    ];
    
    public function category(){
        return $this->belongsTo('App\Category');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    public function likes(){
        return $this->hasMany('App\Like');
    }
    
    public function likedUsers(){
        return $this->belongsToMany('App\User', 'likes');
    }
    
    // 商品が特定のユーザーにいいねされているかどうかをチェック
    public function isLikedBy($user){
        $liked_users_ids = $this->likedUsers->pluck('id');
        $result = $liked_users_ids->contains($user->id);
        return $result;
    }
    
    // 自分以外のuser が出品したItemを取得
    public function scopeRecommend($query, $self_id){
        // コントローラ内メソッド 引数で指定した$self_id 以外のitemsを最新順で並べる
        // 取得後のrecommend はコレクションになる
        // where('A',<>,'B') は A≠Bのものを選択（!= はANSI規格上正しくない）
        return $query->where('user_id', '<>', $self_id)->latest();
    }
    
    public function orders(){
        return $this->hasMany('App\Order');
    }
    
    public function orderedUsers(){
        return $this->belongsToMany('App\User', 'orders');
    }
    
    // 商品が特定のユーザーに購入されているかどうかをチェック
    public function isPurchasedBy($user){
        $purchased_users_ids = $this->orderedUsers->pluck('id');
        // contains の返り値は true or false
        $result = $purchased_users_ids->contains($user->id);
        return $result;
    }
}
