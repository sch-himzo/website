<?php

use App\Models\Slide;
use Illuminate\Database\Seeder;

class SlideSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Slide::create([
            'title' => 'Pulcsi és foltmékör',
            'message' => '<p>Üdvözöljük a pulcsi és foltmékör weboldlán! Itt leadhatja folt rendelését, illetve válogathat aktuális ajánlatunkból (mittudomén)</p>',
            'image' => 'https://www.cats.org.uk/media/2197/financial-assistance.jpg?width=1600',
            'number' => '1'
        ]);

        Slide::create([
            'title' => 'Folt rendelés',
            'message' => "<p><a class='btn btn-lg btn-primary' href='". route('orders.new.create') ."'>Rendelés &raquo;</a></p>",
            'image' => 'https://images2.minutemediacdn.com/image/upload/c_crop,h_1193,w_2121,x_0,y_175/f_auto,q_auto,w_1100/v1554921998/shape/mentalfloss/549585-istock-909106260.jpg',
            'number' => '2'
        ]);

        Slide::create([
            'title' => 'Pulóverek',
            'message' => '<p>Ide jönnek majd a vikes pulcsik hogy miből mennyi van stb</p>',
            'image' => 'https://www.cats.org.uk/media/1400/choosing-a-cat.jpg?width=1600',
            'number' => '3'
        ]);
    }
}
