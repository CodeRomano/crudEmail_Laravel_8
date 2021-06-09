<?php

namespace App\Http\Controllers;

use App\Models\City;

class CityController extends Controller
{
    /**
     * Return cities list filter by state
     * @param $stateId
     * @return false|string
     */
    public function getCitiesByState($stateId)
    {
        $states = City::where('state_id', '=', $stateId)->pluck('name', 'id');
        return json_encode($states);
    }
}
