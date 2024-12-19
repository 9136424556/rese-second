<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NumbersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = ['reserved_number' => '1人'];
        DB::table('numbers')->insert($param);

        $param = ['reserved_number' => '2人'];
        DB::table('numbers')->insert($param);

        $param = ['reserved_number' => '3人'];
        DB::table('numbers')->insert($param);

        $param = ['reserved_number' => '4人'];
        DB::table('numbers')->insert($param);

        $param = ['reserved_number' => '5人'];
        DB::table('numbers')->insert($param);

        $param = ['reserved_number' => '6人'];
        DB::table('numbers')->insert($param);

        $param = ['reserved_number' => '7人'];
        DB::table('numbers')->insert($param);

        $param = ['reserved_number' => '8人'];
        DB::table('numbers')->insert($param);

        $param = ['reserved_number' => '9人'];
        DB::table('numbers')->insert($param);

        $param = ['reserved_number' => '10人'];
        DB::table('numbers')->insert($param);
    }
}
