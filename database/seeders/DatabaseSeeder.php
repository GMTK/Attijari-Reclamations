<?php

namespace Database\Seeders;

use App\Models\Type_client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PermissionsTableSeeder::class,
            RolesTableSeeder::class,
            PermissionRoleTableSeeder::class,
            UsersTableSeeder::class,
            RoleUserTableSeeder::class,
            NivServicesTableSeeder::class,
            NivUrgsTableSeeder::class,
            DevisesTableSeeder::class,
            MonetiquesTableSeeder::class,
            CategoriesTableSeeder::class,
            CanalsTableSeeder::class,
            CanalSecondairesTableSeeder::class,
            AgencesTableSeeder::class,
            TypeClientsTableSeeder::class,
            FamillesTableSeeder::class,
        ]);
    }
}
