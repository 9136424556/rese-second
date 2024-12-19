<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'name' => 'COACHTECH',
            'email' => 'coachtech@coachtech.com',
            'email_verified_at' => '2024-07-20 10:00:00',
            'password' => Hash::make('coachtech'),
            'role' => 'company',
            'remember_token' => ''
        ];
        DB::table('users')->insert($param);
    }
}
