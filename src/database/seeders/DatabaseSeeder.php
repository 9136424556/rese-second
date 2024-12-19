<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        
       // $this->call(GenresTableSeeder::class);
        //$this->call(AreasTableSeeder::class);
        //$this->call(ShopsTableSeeder::class);
        //$this->call(NumbersTableSeeder::class);
        //$this->call(TimesTableSeeder::class);
        //$this->call(StarsTableSeeder::class);
        //$this->call(AdminsTableSeeder::class);
        //$this->call(ManagersTableSeeder::class);
        //$this->call(UsersTableSeeder::class);
        $this->call(ImageTableSeeder::class);
    }
}
