<?php

use Illuminate\Database\Seeder;
use App\Specialization;
use Illuminate\Support\Str;

class SpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $specializzazioni = [
            [
                'name' => 'garden design',
                'image' => 'public/spec_images/garden-design.jpg'
            ],
            [
                'name' => 'giardinaggio',
                'image' => 'public/spec_images/giardinaggio.jpg'
            ],
            [
                'name' => 'bonsai',
                'image' => 'public/spec_images/bonsai.jpg'
            ],
            [
                'name' => 'fiori',
                'image' => 'public/spec_images/fiori.jpg'
            ],
            [
                'name' => 'piante da interni',
                'image' => 'public/spec_images/piante-da-interni.jpg'
            ],
            [
                'name' => 'piante esotiche',
                'image' => 'public/spec_images/piante-esotiche.jpg'
            ],
            [
                'name' => 'piante da frutto',
                'image' => 'public/spec_images/piante-da-frutto.jpg'
            ],
            [
                'name' => 'vigneti',
                'image' => 'public/spec_images/vigneti.jpg'
            ],
            [
                'name' => 'orticoltura',
                'image' => 'public/spec_images/orticoltura.jpg'
            ]
        ];

        foreach($specializzazioni as $specializzazione) {
            // creo un nuovo record 
            $newSpecialization = new Specialization();
            // 
            $newSpecialization->spec_name = $specializzazione['name'];
            $newSpecialization->slug_specialization = Str::slug($specializzazione['name'], '-');
            $newSpecialization->spec_image = $specializzazione['image'];
            $newSpecialization->save();
        };

    }
}