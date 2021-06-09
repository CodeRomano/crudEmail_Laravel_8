<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;
use App\Models\State;

class StatesSeeds extends Seeder
{
    /**
    * Run the database seeds.
    *
    * @return void
    */
    public function run()
    {   

        /** Agregando Provincias de Perú */

        $state = new State();
        $state->country_id = Country::where('name', 'Peru')->value('id');
        $state->name = 'Lima';
        $state->save();
    }
}
