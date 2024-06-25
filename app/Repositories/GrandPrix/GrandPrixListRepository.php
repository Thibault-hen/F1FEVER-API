<?php

namespace App\Repositories\GrandPrix;

use App\Http\Resources\GrandPrixList\GrandPrixListBySeasonResource;
use App\Http\Resources\GrandPrixList\CurrentGrandPrixListResource;
use App\Http\Resources\GrandPrixList\GrandPrixListByNameResource;
use App\Models\Circuits;
use App\Models\Races;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GrandPrixListRepository
{
    public function getCurrentSeasonRounds(): ResourceCollection
    {
        $season = Carbon::now()->year;
        $grandPrixList = Circuits::select("circuits.circuitId", "location", "country", "races.name", "races.time", "races.date")
            ->join("races", "circuits.circuitId", "races.circuitId")
            ->where("races.year", $season)
            ->get();

        return CurrentGrandPrixListResource::collection($grandPrixList);
    }

    public function getRoundsBySeason(int $season): ResourceCollection
    {
        $grandPrixList = Circuits::select("circuits.circuitId", "location", "country", "races.name", "races.time", "races.date")
            ->join("races", "circuits.circuitId", "races.circuitId")
            ->where("races.year", $season)
            ->get();

        return GrandPrixListBySeasonResource::collection($grandPrixList);
    }
    public function getRoundsByName(string $name): ResourceCollection
    {
        $raceId = Races::where("name", $name)
            ->pluck("raceid")
            ->toArray();

        $grandPrixList = Circuits::select(
            "circuits.circuitId",
            "location",
            "country",
            "races.name",
            "races.time",
            "races.date",
            "races.raceId",

            DB::raw("
            GROUP_CONCAT(
                CASE
                    WHEN results.position = 1 THEN CONCAT(drivers.forename, ' ', drivers.surname, ' (', drivers.nationality, ')')
                    WHEN results.position = 2 THEN CONCAT(drivers.forename, ' ', drivers.surname)
                    WHEN results.position = 3 THEN CONCAT(drivers.forename, ' ', drivers.surname)
                END
                ORDER BY results.position SEPARATOR ', '
            ) AS podium
        ")
        )
            ->join("races", "circuits.circuitId", "=", "races.circuitId")
            ->join("results", "races.raceId", "=", "results.raceId")
            ->join("drivers", "results.driverId", "=", "drivers.driverId")
            ->whereIn("races.raceId", $raceId)
            ->whereBetween("results.position", [1, 3])
            ->groupBy("circuits.circuitId", "races.raceId")
            ->orderByDesc("races.date")
            ->get();

        return GrandPrixListByNameResource::collection($grandPrixList);
    }
}
