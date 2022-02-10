<?php

namespace App\Services;

class fileUploadService {
    public function saveImage($image){
        $path = '';
        if( isset($image) === true){
            // publicディスク(storage/app/public/)のphotos ディレクトリに保存
            $path = $image->store('photos', 'public');
        }
        return $path; // 画像が存在しない場合は空文字を返す
    }
}