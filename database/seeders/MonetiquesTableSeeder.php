<?php

namespace Database\Seeders;

use App\Models\monetique;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MonetiquesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $monet = [
            [
                'id'    => 1,
                'titreMonet' => 'AMPLITUDE',
            ],
            [
                'id'    => 2,
                'titreMonet' => 'GABS CONFRERE',
            ],
            [
                'id'    => 3,
                'titreMonet' => 'POWERCARD',
            ],
            [
                'id'    => 4,
                'titreMonet' => 'CAISEE',
            ],
            [
                'id'    => 5,
                'titreMonet' => 'FACTURATIONS',
            ],
            [
                'id'    => 6,
                'titreMonet' => 'COMPENSATION',
            ],
            [
                'id'    => 7,
                'titreMonet' => 'RISQUE',
            ],
            [
                'id'    => 8,
                'titreMonet' => 'TRADE',
            ],
            [
                'id'    => 9,
                'titreMonet' => 'MIDDEL OFFICE',
            ],
            [
                'id'    => 10,
                'titreMonet' => 'BACK OFFICE',
            ],

        ];

        Monetique::insert($monet);
    }
}
