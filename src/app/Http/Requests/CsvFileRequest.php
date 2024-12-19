<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CsvFileRequest extends FormRequest
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
            'csv_file' =>  'required|file|mimes:csv,txt|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'csv_file.required' => 'CSVファイルは必須です。',
            'csv_file.file' => 'アップロードされたファイルが不正です。',
            'csv_file.mimes' => 'CSVファイル形式のみ対応しています。',
            'csv_file.max' => 'CSVファイルは2MB以下でアップロードしてください。',
        ];
    }
}
