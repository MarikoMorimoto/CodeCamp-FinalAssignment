<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'item_id',
    ];
    
    // Item, User モデルで多対多のリレーションを設定しているためここでの設定は不要
    // public function items(){
    //     return $this->belongsToMany('App\Item');
    // }
    
    // public function users(){
    //     return $this->belongsToMany('App\User');
    // }
}
