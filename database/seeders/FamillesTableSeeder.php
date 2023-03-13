<?php

namespace Database\Seeders;

use App\Models\Famille;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamillesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $fams = [
            [
                'id'    => 1,
                'titreFamilleRec' => 'AMPLITUDE',

            ],
            [
                'id'    => 2,
                'titreFamilleRec' => 'MONETIQUE',

            ],
        ];

        Famille::insert($fams);
    }
}
