<?php

namespace Database\Seeders;

use App\Models\devise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $devise = [
            [
                'id'    => 1,
                'titreDevi' => 'Ouguiya',
            ],
            [
                'id'    => 2,
                'titreDevi' => 'Dollars',
            ],
            [
                'id'    => 3,
                'titreDevi' => 'Euros',
            ],

        ];

        Devise::insert($devise);

    }
}
