<?php

namespace Database\Seeders;

use App\Models\CanalSecondaire;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CanalSecondairesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $canalSec = [
            [
                'id'    => 1,
                'titreCanalSecondaire' => 'Organisation',
            ],
            [
                'id'    => 2,
                'titreCanalSecondaire' => 'Audit',
            ],
            [
                'id'    => 3,
                'titreCanalSecondaire' => 'Controle',
            ],
            [
                'id'    => 4,
                'titreCanalSecondaire' => 'Direction',
            ],
            [
                'id'    => 5,
                'titreCanalSecondaire' => 'Comptabilité',
            ],
            [
                'id'    => 6,
                'titreCanalSecondaire' => 'Réclamation',
            ],
        ];

        CanalSecondaire::insert($canalSec);
    }
}
