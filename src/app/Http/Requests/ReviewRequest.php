<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
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
            'shop_id' => 'required|integer',
            'evaluate' => 'required',
            'review_comment' => 'nullable|max:400',
            'image' => 'nullable|file|mimes:jpeg,png|max:2048', // 画像はjpeg/pngのみ、最大2MB
        ];
    }

    public function messages()
    {
        return [
            'evaluate.required' => '星の数を入力してください',
            'review_comment.max' => '400字以内でコメントを入力してください',
            'image.mimes' => '画像はJPEGまたはPNG形式のみアップロードできます。',
            'image.max' => '画像のサイズは2MB以下にしてください。'
        ];
    }
}
