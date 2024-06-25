<?php

namespace App\Repositories\RaceSchedule;

use App\Models\Circuits;
use App\Models\Races;
use Carbon\Carbon;
use App\Http\Resources\RaceSchedule\NextRaceResource;

class RaceScheduleRepository
{
    protected int $season;
    public function __construct()
    {
        $this->season = Carbon::now()->year;
    }

    private function getLastRound(): int
    {
        return Races::join("results", "races.raceId", "results.raceId")
            ->where("races.year", $this->season)
            ->max("races.round");
    }

    public function getNextRound() : NextRaceResource
    {
        $lastRound = $this->getLastRound() + 1;

        $nextRaceInfo = Races::where("round", $lastRound)
            ->where("year", $this->season)
            ->firstOrFail();

        $nextRaceCircuit = Circuits::where("circuitId", $nextRaceInfo->circuitId)
            ->firstOrFail();

        $mergedData = array_merge($nextRaceInfo->toArray(), $nextRaceCircuit->toArray());
        
        return new NextRaceResource((object)$mergedData);
    }

    public function getLastGpName(): string
    {
        $lastRound = $this->getLastRound();
        return Races::where("races.round", $lastRound)
            ->where("year", $this->season)
            ->value("name");
    } 
}
