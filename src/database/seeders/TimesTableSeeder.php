<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = ['reserved_time' => '09:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '10:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '11:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '12:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '13:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '14:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '15:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '16:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '17:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '18:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '19:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '20:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '21:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '22:00'];
        DB::table('times')->insert($param);

        $param = ['reserved_time' => '23:00'];
        DB::table('times')->insert($param);
    }
}
