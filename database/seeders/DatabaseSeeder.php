<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::beginTransaction();
        // Control de acceso
        $this->call(MenuSeeder::class);
        $this->call(RouteSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(LogSeeder::class);
        $this->call(UserSeeder::class);
        UserSeeder::createInitAccess();
        // Fin control de acceso

        $this->call(ClientSeeder::class);


        DB::commit();
    }
}
