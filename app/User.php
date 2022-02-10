<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'profile', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    // リレーションを設定
    // 下記のコードにより、User インスタンスのitems プロパティに
    // 該当のUser インスタンスに紐づくitems インスタンスが設定される。
    public function items(){
        return $this->hasMany('App\Item');
    }
    
    public function likes(){
        return $this->hasMany('App\Like');
    }
    
    public function likeItems(){
        // いいねに追加した時間で降順に並べ替え
        return $this->belongsToMany('App\Item', 'likes')
                    ->withPivot('created_at')
                    ->orderBy('pivot_created_at', 'desc');
    }
    
    // 購入履歴 中間テーブルordersのリレーション
    public function orders(){
        return $this->hasMany('App\Order');
    }
    
    public function orderedItems(){
        // 商品を購入した時間で降順に並べ替え
        return $this->belongsToMany('App\Item', 'orders')
                    ->withPivot('created_at')
                    ->orderBy('pivot_created_at', 'desc');
    }
}
