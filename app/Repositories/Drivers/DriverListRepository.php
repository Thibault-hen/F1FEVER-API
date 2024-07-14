<?php

namespace App\Repositories\Drivers;

use App\Models\Drivers;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Drivers\AllDriversResource;
use App\Http\Resources\Drivers\AllDriversBySeasonResource;

class DriverListRepository
{
    /**
     * Retrieve all driver information
     * 
     * @return ResourceCollection
     */
    public function getAllDrivers(): ResourceCollection
    {
        return AllDriversResource::collection(Drivers::all());
    }

    /**
     * Retrieve all driver information with the given season
     * 
     * @param int $season
     * @return ResourceCollection
     */
    public function getAllDriversBySeason(int $season): ResourceCollection
    {
        return AllDriversBySeasonResource::collection(
            Drivers::select('drivers.*')
                ->distinct()
                ->join("driverstandings", "drivers.driverId", "driverstandings.driverId")
                ->join("races", "driverstandings.raceId", "races.raceId")
                ->where("races.year", $season)
                ->orderBy("drivers.number")
                ->get()
        );
    }
}
