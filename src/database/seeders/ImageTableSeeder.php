<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ImageTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'image_name' => 'yakiniku',
            'image_url' => 'storage/image/yakiniku.jpg'
        ];
        DB::table('images')->insert($param);

        $param = [
            'image_name' => 'sushi',
            'image_url' => 'storage/image/sushi.jpg'
        ];
        DB::table('images')->insert($param);

        $param = [
            'image_name' => 'ramen',
            'image_url' => 'storage/image/ramen.jpg'
        ];
        DB::table('images')->insert($param);

        $param = [
            'image_name' => 'izakaya',
            'image_url' => 'storage/image/izakaya.jpg'
        ];
        DB::table('images')->insert($param);

        $param = [
            'image_name' => 'italian',
            'image_url' => 'storage/image/italian.jpg'
        ];
        DB::table('images')->insert($param);
    }
}
