<?php

namespace App\Service;

use App\Models\Location;

class LocationService
{
    public static function getLocationsHot($limit)
    {
        return Location::withCount('rooms')->where('hot',1)->limit($limit)->get();
    }
}
