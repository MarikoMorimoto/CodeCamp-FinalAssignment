<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileImageRequest extends FormRequest
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
            'image' => [
                'required',
                'file', // ファイルがアップロードされているか
                'image',
                'mimes:jpeg,jpg,png',
                'dimensions:min_width=10,min_height=10,max_width=500,max_height=500',
            ],
        'file' => ['max:10000'], // ファイルサイズ 最大10MB
        ];
    }
}
