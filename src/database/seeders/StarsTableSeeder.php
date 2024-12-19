<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = ['star' => '★★★★★' ];
        DB::table('stars')->insert($param);

        $param = [ 'star' => '★★★★☆' ];
        DB::table('stars')->insert($param);

        $param = [ 'star' => '★★★☆☆' ];
        DB::table('stars')->insert($param);

        $param = [ 'star' => '★★☆☆☆' ];
        DB::table('stars')->insert($param);

        $param = [ 'star' => '★☆☆☆☆' ];
        DB::table('stars')->insert($param);
    }
}
