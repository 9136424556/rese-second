<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ManagersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'shop_id' => 2,
            'name' => '代表一',
            'email' => 'manager-1@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager1'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 3,
            'name' => '代表二',
            'email' => 'manager-2@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager2'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 4,
            'name' => '代表三',
            'email' => 'manager-3@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager3'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 5,
            'name' => '代表四',
            'email' => 'manager-4@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager4'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 6,
            'name' => '代表五',
            'email' => 'manager-5@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager5'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 7,
            'name' => '代表六',
            'email' => 'manager-6@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager6'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 8,
            'name' => '代表七',
            'email' => 'manager-7@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager7'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 9,
            'name' => '代表八',
            'email' => 'manager-8@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager8'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 10,
            'name' => '代表九',
            'email' => 'manager-9@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager9'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 11,
            'name' => '代表十',
            'email' => 'manager-10@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager10'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 12,
            'name' => '代表十一',
            'email' => 'manager-11@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager11'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 13,
            'name' => '代表十二',
            'email' => 'manager-12@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager12'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 14,
            'name' => '代表十三',
            'email' => 'manager-13@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager13'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 15,
            'name' => '代表十四',
            'email' => 'manager-14@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager14'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 16,
            'name' => '代表十五',
            'email' => 'manager-15@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager15'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 17,
            'name' => '代表十六',
            'email' => 'manager-16@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager16'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 18,
            'name' => '代表十七',
            'email' => 'manager-17@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager17'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 19,
            'name' => '代表十八',
            'email' => 'manager-18@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager18'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 20,
            'name' => '代表十九',
            'email' => 'manager-19@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager19'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);

        $param = [
            'shop_id' => 21,
            'name' => '代表二十',
            'email' => 'manager-20@manager.com',
            'email_verified_at' => '2024-05-15 10:35:00',
            'password' => Hash::make('manager20'),
            'remember_token' => ''
        ];
        DB::table('managers')->insert($param);
    }
}
