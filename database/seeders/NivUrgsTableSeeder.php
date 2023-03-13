<?php

namespace Database\Seeders;

use App\Models\Niveauurgence;
use App\Models\NivUrg;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NivUrgsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Urg = [
            [
                'id'    => 1,
                'titreUrg' => 'Majeur',
            ],
            [
                'id'    => 2,
                'titreUrg' => 'Fort',
            ],
            [
                'id'    => 3,
                'titreUrg' => 'Significatif',
            ],
            [
                'id'    => 4,
                'titreUrg' => 'Mineur',
            ],

        ];

        NivUrg::insert($Urg);
    }
}
