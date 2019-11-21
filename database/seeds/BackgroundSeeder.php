<?php

use App\Models\Background;
use Illuminate\Database\Seeder;

class BackgroundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Background::create([
            'name' => 'Light Blue',
            'red' => '215',
            'green' => '215',
            'blue' => '215'
        ]);
        Background::create([
            'name' => 'Capriblue X057',
            'red' => '100',
            'green' => '195',
            'blue' => '182'
        ]);
        Background::create([
            'name' => 'Royal Blue T054',
            'red' => '53',
            'green' => '77',
            'blue' => '140'
        ]);
        Background::create([
            'name' => 'Royal Blue X038',
            'red' => '48',
            'green' => '47',
            'blue' => '128'
        ]);
        Background::create([
            'name' => 'Heliotrope',
            'red' => '89',
            'green' => '55',
            'blue' => '128'
        ]);
        Background::create([
            'name' => 'Light Pink',
            'red' => '231',
            'green' => '177',
            'blue' => '150'
        ]);
        Background::create([
            'name' => 'White',
            'red' => '255',
            'green' => '255',
            'blue' => '255'
        ]);
        Background::create([
            'name' => 'Silver T094',
            'red' => '140',
            'green' => '136',
            'blue' => '130'
        ]);
        Background::create([
            'name' => 'Black',
            'red' => '0',
            'green' => '0',
            'blue' => '0'
        ]);
        Background::create([
            'name' => 'Bitter Chocolate X088',
            'red' => '55',
            'green' => '42',
            'blue' => '26'
        ]);
        Background::create([
            'name' => 'Cinnamon X030',
            'red' => '94',
            'green' => '70',
            'blue' => '47'
        ]);
        Background::create([
            'name' => 'Rosewood X027',
            'red' => '93',
            'green' => '27',
            'blue' => '23'
        ]);
        Background::create([
            'name' => 'Hot Red T017',
            'red' => '208',
            'green' => '51',
            'blue' => '51'
        ]);
        Background::create([
            'name' => 'Grenadine Red T015',
            'red' => '152',
            'green' => '59',
            'blue' => '45'
        ]);
        Background::create([
            'name' => 'Orange T014',
            'red' => '220',
            'green' => '116',
            'blue' => '45'
        ]);
        Background::create([
            'name' => 'Saffron T007',
            'red' => '242',
            'green' => '191',
            'blue' => '73'
        ]);
        Background::create([
            'name' => 'Butter Yellow T003',
            'red' => '246',
            'green' => '237',
            'blue' => '59'
        ]);
        Background::create([
            'name' => 'Applecinnamon X008',
            'red' => '233',
            'green' => '206',
            'blue' => '134'
        ]);
        Background::create([
            'name' => 'Olive',
            'red' => '90',
            'green' => '102',
            'blue' => '54'
        ]);
        Background::create([
            'name' => 'Jade Lime X065',
            'red' => '213',
            'green' => '237',
            'blue' => '96'
        ]);
        Background::create([
            'name' => 'Deep Green T078',
            'red' => '32',
            'green' => '88',
            'blue' => '70'
        ]);
        Background::create([
            'name' => 'Insignia Blue X049',
            'red' => '24',
            'green' => '27',
            'blue' => '50'
        ]);
        Background::create([
            'name' => 'Fluor Pink X022',
            'red' => '236',
            'green' => '90',
            'blue' => '155'
        ]);
        Background::create([
            'name' => 'TwoTone (Szürke-Fekete)',
            'red' => '46',
            'green' => '50',
            'blue' => '56'
        ]);
    }
}
