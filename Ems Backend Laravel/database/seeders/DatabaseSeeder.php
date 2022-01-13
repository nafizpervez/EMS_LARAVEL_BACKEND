<?php

namespace Database\Seeders;

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
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ExtendedUserDetailSeeder::class);
        $this->call(SaleForcastSeeder::class);
        $this->call(InventorySeeder::class);
        $this->call(AllotedLeaveSeeder::class);
    }
}
