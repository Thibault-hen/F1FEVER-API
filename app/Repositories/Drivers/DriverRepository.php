<?php

namespace App\Repositories\Drivers;

use App\Http\Resources\Drivers\DriverResource;
use App\Models\Drivers;
use App\Models\DriverStandings;
use App\Models\Races;
use App\Models\Results;
use App\Models\Sprintresults;
use App\Services\WikiDataService;
use Illuminate\Support\Facades\DB;

class DriverRepository
{
    protected int $driverId;
    protected $driverBasicData;
    protected $driverFirstRace = [];
    protected $driverLastRace = [];
    protected $driverWikiImg;
    protected $driverRaceStats;
    protected $driverTotalSeasons;
    public function __construct(
        protected WikiDataService $wikiDataService
    ) {
    }

    private function setDriverId(string $name): void
    {
        $this->driverId = Drivers::where('driverRef', $name)
            ->value('driverId');
    }

    private function setDriverBasicData(): void
    {
        $this->driverBasicData = Drivers::find($this->driverId);
    }

    private function setDriverFirstRace(): void
    {
        //Retrieving the first race year and round value in order to get the proper race name and country
        $firstRaceDate = Results::select(
            DB::raw('MIN(races.year) as first_race_year'),
            DB::raw('MIN(races.round) as first_race_round')
        )
            ->join('races', 'results.raceId', 'races.raceId')
            ->where('results.driverId', $this->driverId)
            ->first();

        $firstRaceData = Races::select('races.name', 'circuits.country')
            ->join('circuits', 'races.circuitId', 'circuits.circuitId')
            ->where('races.year', $firstRaceDate->first_race_year)
            ->where('races.round', $firstRaceDate->first_race_round)
            ->get()
            ->map(function ($race) use ($firstRaceDate) {
                $race->first_race_year = $firstRaceDate->first_race_year;
                return $race;
            });

        if ($firstRaceData) {
            $this->driverFirstRace = $firstRaceData;
        }
    }

    private function setDriverLastRace(): void
    {
        //Retrieving the first race year and round value in order to get the proper race name and country
        $lastRaceDate = DriverStandings::select(
            DB::raw('MAX(races.year) as last_race_year'),
            DB::raw('MAX(races.raceId) as last_race_id')
        )
            ->join('races', 'driverStandings.raceId', 'races.raceId')
            ->where('driverStandings.driverId', $this->driverId)
            ->first();

        $lastRaceData = Races::select('races.name', 'circuits.country')
            ->join('circuits', 'races.circuitId', 'circuits.circuitId')
            ->where('races.year', $lastRaceDate->last_race_year)
            ->where('races.raceId', $lastRaceDate->last_race_id)
            ->get()
            ->map(function ($race) use ($lastRaceDate) {
                $race->last_race_year = $lastRaceDate->last_race_year;
                return $race;
            });

        if ($lastRaceData) {
            $this->driverLastRace = $lastRaceData;
        }
    }

    private function setRaceStats(): void
    {
        $raceStats = Drivers::with('results', 'sprintResults')
            ->where('driverId', $this->driverId)
            ->get();

        $mergedStats = $raceStats->map(function ($result) {
            return [
                'totalRaces' => $result->results->count(),
                'totalWins' => $result->results->where('positionText', 1)->count(),
                'totalPodiums' => $result->results->whereBetween('positionText', [1, 3])->count(),
                'totalPoles' => $result->results->where('grid', 1)->count(),
                'totalPoints' => $result->results->sum('points') + $result->sprintResults->sum('points'),
                'totalLaps' => $result->results->sum('laps'),
            ];
        });

        $this->driverRaceStats = $mergedStats;
    }

    public function setActiveSeasons(): void
    {
        $totalSeasons = Results::select('races.year')
            ->where('results.driverId', $this->driverId)
            ->join('races', 'results.raceId', '=', 'races.raceId')
            ->groupBy('races.year')
            ->get();

        $this->driverTotalSeasons = collect($totalSeasons);
    }
    
    public function getDriverData(string $name): DriverResource
    {
        $this->setDriverId($name);

        $this->setActiveSeasons();
        $this->setDriverBasicData();
        $this->setDriverFirstRace();
        $this->setDriverLastRace();
        $this->setRaceStats();

        $this->wikiDataService->setWikiData($this->driverBasicData->first()->url);
        $this->driverWikiImg = $this->wikiDataService->getWikiImg();

        return new DriverResource([
            'basicData' => [
                'driver' => $this->driverBasicData,
                'wikiImg' => $this->driverWikiImg,
            ],
            'raceStats' => $this->driverRaceStats,
            'firstRaceEntered' => $this->driverFirstRace,
            'lastRaceEntered' => $this->driverLastRace,
            'totalSeasons' => [
                "total" => $this->driverTotalSeasons->count(),
                "year" => $this->driverTotalSeasons->pluck('year'),
            ]
        ]);
    }
}
