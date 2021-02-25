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
        // $this->call(UserSeeder::class);
        $this->call(BloodsSeeder::class);
        $this->call(NationalitiesSeeder::class);
        $this->call(ReligionsSeeder::class);
    }
}
