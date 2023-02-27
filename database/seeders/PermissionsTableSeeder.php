<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            [
                'id'    => 1,
                'title' => 'create:user',
                'description' => "Creation d'un utilisateur",
            ],
            [
                'id'    => 2,
                'title' => 'create:permission',
                'description' => "creation d'une permission",
            ],
        ];

        Permission::insert($permissions);
    }
}
