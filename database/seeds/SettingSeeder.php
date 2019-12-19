<?php

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
//        Setting::create([
//            'name' => 'home_gallery',
//            'setting' => 1,
//            'description' => 'Az a galéria ami a főoldalon megjelenik'
//        ]);
//
//        Setting::create([
//            'name' => 'orders_gallery',
//            'setting' => 1,
//            'description' => 'A rendelésekhez kapcsolódó galéria'
//        ]);
//
//        Setting::create([
//            'name' => 'orders_group',
//            'setting' => 1,
//            'description' => 'A rendelésekhez kapcsolódo mappa'
//        ]);

        Setting::create([
            'name' => 'machine_state',
            'setting' => 0,
            'description' => 'A hímzőgép aktuális állapota'
        ]);
    }
}
