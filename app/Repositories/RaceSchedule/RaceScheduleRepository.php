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

    /**
     * Retrieve the last race round number for the current season.
     * 
     * @return ?int
     */
    private function getLastRound(): ?int
    {
        return Races::join("results", "races.raceId", "results.raceId")
            ->where("races.year", $this->season)
            ->max("races.round");
    }


    /**
     * Retrieve the next race round for the current season using result from the getLastRound() method
     * 
     * @return NextRaceResource
     */
    public function getNextRound(): NextRaceResource
    {
        $lastRound = $this->getLastRound() + 1;

        $nextRaceInfo = Races::where("round", $lastRound)
            ->where("year", $this->season)
            ->firstOrFail();

        $formattedRaceInfo = [
            'year' => $nextRaceInfo->year,
            'time' => $nextRaceInfo->time,
            'date' => $nextRaceInfo->date,
            'gp_name' => $nextRaceInfo->name,
        ];

        $nextRaceCircuit = Circuits::where("circuitId", $nextRaceInfo->circuitId)
            ->firstOrFail();

        $mergedData = array_merge($formattedRaceInfo, $nextRaceCircuit->toArray());
        return new NextRaceResource((object) $mergedData);
    }


    /**
     * Retrieve the grand prix name of the last race using the result from the getLastRound method
     * 
     * @return string
     */
    public function getLastGpName(): string
    {
        $lastRound = $this->getLastRound();

        return Races::where("races.round", $lastRound)
            ->where("year", $this->season)
            ->value("name");
    }
}
