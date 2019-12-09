<?php

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
//        $this->call(BackgroundSeeder::class);
//        $this->call(RolesSeeder::class);
        $this->call(SettingSeeder::class);
//        $this->call(SlideSeeder::class);
    }
}
