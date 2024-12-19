<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservationRequest extends FormRequest
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
            'date' => ['required','after:yesterday', 'date'],
            'time' => ['required'],
            'number' => ['required'],
        ];
    }
    public function messages()
    {
        return [
            'date.required' => '日付は必須です',
            'date.after' => '日付は昨日以降の日付で入力してください',
            'time.required' => '予約時間を入力してください',
            'number.required' => '人数入力は必須です',
        ];
        
    }
}
