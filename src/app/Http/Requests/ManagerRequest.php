<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ManagerRequest extends FormRequest
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
            'name' => 'required',
            'area' => 'required',
            'genre' => 'required',
            'comment' => 'required|max:250',
            'img_url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name . required' => '店舗名を入力してください',
            'area . required' => '地域を入力してください',
            'genre . required' => 'ジャンルを入力してください',
            'comment . required' => '店舗概要を入力してください',
            'comment . max' => '店舗概要は250文字以下にしてください',
            'img_url . required' => '画像を選択してください',
        ];
    }
}
