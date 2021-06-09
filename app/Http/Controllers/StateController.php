<?php

namespace App\Http\Controllers;

use App\Models\State;

class StateController extends Controller
{
    /**
     * return  states filter by country
     * @param $countryId
     * @return false|string
     */
    public function getStatesByCountry($countryId)
    {
        $states = State::where('country_id', '=', $countryId)->pluck('name', 'id');
        return json_encode($states);
    }
}
