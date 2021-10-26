<?php

use Illuminate\Database\Seeder;
use App\Promo;

class PromoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $newPromo= new Promo();
        $newPromo->name = 'Silver';
        $newPromo->duration = 24;
        $newPromo->price = 2.99;

        $newPromo1= new Promo();
        $newPromo1->name = 'Gold';
        $newPromo1->duration = 72;
        $newPromo1->price = 5.99;

        $newPromo2= new Promo();
        $newPromo2->name = 'Platinum';
        $newPromo2->duration = 144;
        $newPromo2->price = 9.99;

        $newPromo->save();

        $newPromo1->save();

        $newPromo2->save();
    }
}
