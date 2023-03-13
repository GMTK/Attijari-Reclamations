<?php

namespace Database\Seeders;

use App\Models\Canal;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CanalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $canal = [
            [
                'id'    => 1,
                'titreCanal' => 'Agence',
            ],
            [
                'id'    => 2,
                'titreCanal' => 'Service',
            ],
            [
                'id'    => 3,
                'titreCanal' => 'Direction',
            ],

        ];

        Canal::insert($canal);
    }
}
