<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileImageRequest;
use App\Services\FileUploadService;
use App\Http\Requests\ProfileRequest;
// email のバリデーションのために呼び出し
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit(){
        $user = \Auth::user();
        return view('profile.edit', [
            'title' => 'Market | プロフィール編集',
            'user' => $user,
        ]);
    }
    
    public function update(ProfileRequest $request){
        $user = \Auth::user();
        // メールアドレスの編集時に、
        // すでにデータベースに登録されている項目との重複は許さないが
        // 自分自身のメールアドレスとは重複しても構わないようにする
        $request->validate([
            'email' => [Rule::unique('users')->ignore($user->id)],
        ]);
        $user->update([
            'name' => $request->name,
            'profile' => $request->profile,
        ]);
        session()->flash('success', 'プロフィールを編集しました');
        return redirect()->route('users.index');
    }
    
    public function editImage(){
        $user = \Auth::user();
        return view('profile.edit_image', [
            'title' => 'Market | プロフィール画像編集',
            'user' => $user,
        ]);
    }
    
    public function updateImage(ProfileImageRequest $request, FileUploadService $service){
        $path = $service->saveImage($request->file('image'));
        $user = \Auth::user();
        // 変更前に画像が空「''」でなかったら、変更前の画像を削除
        if($user->image !== ''){
            \Storage::disk('public')->delete(\Storage::url($user->image));
        }
        // laravel_market/storage/ が非公開のフォルダになっていると画像が公開できない
        // php artisan storage:link コマンドを実行
        // storage/ に対してシンボリックが貼られ 画像を公開できるようになる
        
        $user->update([
            'image' => $path, // ファイル名を保存
        ]);
        
        session()->flash('success', 'プロフィール画像を変更しました');
        return redirect()->route('users.index');
    }
}
