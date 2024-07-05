<?php

namespace App\Repositories\Drivers;

use App\Models\Drivers;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\Drivers\AllDriversResource;
use App\Http\Resources\Drivers\AllDriversBySeasonResource;

class DriverListRepository
{
    public function getAllDrivers(): ResourceCollection
    {
        return AllDriversResource::collection(Drivers::all());
    }
    public function getAllDriversBySeason(int $season): ResourceCollection
    {
        $drivers = Drivers::select('drivers.*')
            ->distinct()
            ->join("driverstandings", "drivers.driverId", "driverstandings.driverId")
            ->join("races", "driverstandings.raceId", "races.raceId")
            ->where("races.year", $season)
            ->orderBy("drivers.number")
            ->get();

        return AllDriversBySeasonResource::collection($drivers);
    }
}
