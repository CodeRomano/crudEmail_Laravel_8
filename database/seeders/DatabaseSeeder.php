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
        $this->call(CountriesSeeds::class);
        $this->call(StatesSeeds::class);
        $this->call(CitiesSeeds::class);
        $this->call(UsersSeeds::class);
    }
}
