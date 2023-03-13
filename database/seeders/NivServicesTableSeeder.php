<?php

namespace Database\Seeders;

use App\Models\NivService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NivServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $Niv = [
            [
                'id'    => 1,
                'titreNiv' => 'FONCTIONNAIRES',
            ],
            [
                'id'    => 2,
                'titreNiv' => 'GRANDES ENTREPRISES',
            ],
            [
                'id'    => 3,
                'titreNiv' => 'PRIVILEGE',
            ],
            [
                'id'    => 4,
                'titreNiv' => 'SERVICE',
            ],
            [
                'id'    => 5,
                'titreNiv' => 'ESSENTIEL',
            ],
            [
                'id'    => 6,
                'titreNiv' => 'ELITE',
            ],
            [
                'id'    => 7,
                'titreNiv' => 'PME',
            ],
            [
                'id'    => 8,
                'titreNiv' => 'TPE',
            ],
            [
                'id'    => 9,
                'titreNiv' => 'PRESTIGE',
            ],
            [
                'id'    => 10,
                'titreNiv' => 'CLUB',
            ],
            [
                'id'    => 11,
                'titreNiv' => 'A ENRECHIR',
            ],
            [
                'id'    => 12,
                'titreNiv' => 'GRAND PUBLIC',
            ],

        ];

        NivService::insert($Niv);
    }
}
