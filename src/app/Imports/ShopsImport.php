<?php

namespace App\Imports;

use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\WithValidation;

class ShopsImport implements ToModel, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // データ検証＆保存
        $area = Area::where('name', $row[1])->first();
        $genre = Genre::where('name', $row[2])->first();

        if(!$area || !$genre) {
            Log::warning("Invalid area or genre: {$row[1]}, {$row[2]}");
            return null; // 無効なデータはスキップ
        }
        return new Shop([
            'shop_name' => $row[0],
            'area_id' => $area->id,
            'genre_id' => $genre->id,
            'image' => $this->processImage($row[3]),
            'introduction' => $row[4],
        ]);
    }

    private function processImage($imagePath)
    {
        if (filter_var($imagePath, FILTER_VALIDATE_URL)) {
            $imageFileName = 'image/' . uniqid() . '.jpg';
            Storage::put('public/' . $imageFileName, file_get_contents($imagePath));
            return $imageFileName;
        }
        return null;
    }
    public function rules(): array
    {
        return [
            '0' => 'required|string|max:50', // shop_name
            '1' => [
                'required',
                'string',
                 Rule::exists('areas', 'name') // areas テーブルの name カラムに存在するか確認
             ] , // area
            '2' => [
                'required',
                'string',
                Rule::exists('genres','name')
            ], // genre
            '3' => 'required|url', // image (URL形式)
            '4' => 'required|string|max:500', // introduction
        ];
    }
}
