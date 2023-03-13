<?php

namespace Database\Seeders;

use App\Models\agence;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AgencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $agence = [
            [
                'id'    => 1,
                'titreAg' => 'AGENCE MARCHE CAPITAL',
            ],
            [
                'id'    => 2,
                'titreAg' => 'NOUAKCHOTT',
            ],
            [
                'id'    => 3,
                'titreAg' => 'AGENCE ARAFAT',
            ],
            [
                'id'    => 4,
                'titreAg' => 'AGENCE TEYARETT',
            ],
            [
                'id'    => 5,
                'titreAg' => 'AGENCE TIGUINT',
            ],
            [
                'id'    => 6,
                'titreAg' => 'AGENCE PLAGE',
            ],
            [
                'id'    => 7,
                'titreAg' => 'AGENCE MOKHTAR DADAH',
            ],
            [
                'id'    => 8,
                'titreAg' => 'AGENCE MEDINA',
            ],  [
                'id'    => 9,
                'titreAg' => 'AGENCE DAR NAIM',
            ],
            [
                'id'    => 10,
                'titreAg' => 'BUREAU CHAMI',
            ],
            [
                'id'    => 11,
                'titreAg' => 'BUREAU TINTANE',
            ],
            [
                'id'    => 12,
                'titreAg' => 'CENTRE DAFFAIRE SIEGE',
            ],
            [
                'id'    => 13,
                'titreAg' => 'SOCIM-NOUAKCHOTT',
            ],
            [
                'id'    => 14,
                'titreAg' => 'KSAR-NOUAKCHOTT',
            ],
            [
                'id'    => 15,
                'titreAg' => 'CARREFOUR-NOUAKCHOTT',
            ],
            [
                'id'    => 16,
                'titreAg' => 'ZOUERATT',
            ],
            [
                'id'    => 17,
                'titreAg' => 'SEBKHA',
            ],
            [
                'id'    => 18,
                'titreAg' => 'AGENCE LASPALMAS',
            ],
            [
                'id'    => 19,
                'titreAg' => 'SITE CENTRAL',
            ] ,
            [
                'id'    => 20,
                'titreAg' => 'NOUADHIBOU',
            ],
            [
                'id'    => 21,
                'titreAg' => 'AGENCE NOUADHIBOU 2',
            ],
            [
                'id'    => 22,
                'titreAg' => 'AGENCE CENTRAL DAFFAIRE NDB1',
            ],
            [
                'id'    => 23,
                'titreAg' => 'AGENCE VIP NOUADHIBOU',
            ],
            [
                'id'    => 24,
                'titreAg' => 'AGENCE SELIBABY ',
            ],
            [
                'id'    => 25,
                'titreAg' => 'AGENCE MONOTEL',
            ],
            [
                'id'    => 26,
                'titreAg' => 'AGENCE ESPOIRE',
            ],
            [
                'id'    => 27,
                'titreAg' => 'AGENCE DE GESTION',
            ],
            [
                'id'    => 28,
                'titreAg' => 'BUREAU PORT AUTONOME DE NKTT',
            ],
            [
                'id'    => 29,
                'titreAg' => 'ROSSO',
            ],
            [
                'id'    => 30,
                'titreAg' => 'AGENCE KIFFA',
            ],
            [
                'id'    => 31,
                'titreAg' => 'AGENCE VIP',
            ],
            [
                'id'    => 32,
                'titreAg' => 'BUREAU PK55',
            ],


        ];

        Agence::insert($agence);
    }
}
