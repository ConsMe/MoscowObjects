<?php

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
            // UsersTableSeeder::class,
            // ObjectsTableSeeder::class,
            // ChangeIPNBgColor::class
            // RetailsSeeder::class
            // ChangeBuildingTypes::class
        ]);
    }
}
