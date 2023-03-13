<?php

namespace Database\Seeders;

use App\Models\Categorie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat = [
            [
                'id'    => 1,
                'titreCat' => 'Client',
            ],
            [
                'id'    => 2,
                'titreCat' => 'Compte',
            ],
            [
                'id'    => 3,
                'titreCat' => 'Comptabilite',
            ],
            [
                'id'    => 4,
                'titreCat' => 'Ajous',
            ],
            [
                'id'    => 5,
                'titreCat' => 'Engagent',
            ],
            [
                'id'    => 6,
                'titreCat' => 'Dat',
            ],
            [
                'id'    => 7,
                'titreCat' => 'Caution',
            ],

        ];

        Categorie::insert($cat);
    }
}
