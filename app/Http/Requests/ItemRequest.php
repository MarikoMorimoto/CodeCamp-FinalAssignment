<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'max:255'],
            // 半角、全角の指定をいれる（統一性）
            'description' => ['required', 'max:1000'],
            'price' => ['required', 'integer', 'min:0'],
            // 特定のテーブルのカラムを使用して存在チェック
            'category_id' => ['required', 'exists:categories,id'],
            'image' => [
                'required',
                'file', // ファイルがアップロードされているか
                'image',
                'mimes:jpeg,jpg,png',
                'dimensions:min_width=50,min_height=50,max_width=1000,max_height=1000',
            ],
        ];
    }
}
