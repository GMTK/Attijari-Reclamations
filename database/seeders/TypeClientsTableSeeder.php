<?php

namespace Database\Seeders;

use App\Models\Type_client;
use App\Models\TypeClient;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $type = [
            [
                'id'    => 1,
                'titreCli' => 'ENTREPRISE',
            ],
            [
                'id'    => 2,
                'titreCli' => 'PARTICULIER',
            ],
            [
                'id'    => 3,
                'titreCli' => 'PROFESSIONNEL',
            ],

        ];

        TypeClient::insert($type);
    }
}
