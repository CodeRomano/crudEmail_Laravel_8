<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\State;
use App\Models\City;

class CitiesSeeds extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {   
        /* Agregando distritos de Lima  */
        $city = new City();
        $city->state_id = State::where('name', 'Lima')->value('id');
        $city->name = 'La Molina';
        $city->save();     
    }
}
