<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // User,Item モデルで多対多のリレーションを設定しているためここでの設定は不要
    // public function user(){
    //     return $this->belongsTo('App\User');
    // }
    
    // public function item(){
    //     return $this->belongsTo('App\Item');
    // }
    
    protected $fillable = [
        'user_id',
        'item_id',
    ];
}
