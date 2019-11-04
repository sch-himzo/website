<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => 'Default',
            'description' => 'Alap'
        ]);

        Role::create([
            'name' => 'Próbás',
            'description' => 'Próbás'
        ]);

        Role::create([
            'name' => 'Tag',
            'description' => 'Körtag'
        ]);

        Role::create([
            'name' => 'Gazdaságis',
            'description' => 'A kör gazdaságisa'
        ]);

        Role::create([
            'name' => 'Körvezető',
            'description' => 'Körvezető'
        ]);

        Role::create([
            'name' => 'Web Admin',
            'description' => 'A weboldal adminisztrátora'
        ]);
    }
}
