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
    protected $wikiDataService;
    protected $driverBasicData;
    protected $driverFirstRace = [];
    protected $driverLastRace = [];
    protected $driverWikiImg;
    protected $driverRaceStats;
    protected $driverTotalSeasons;
    public function __construct(WikiDataService $wikiDataService)
    {
        $this->wikiDataService = $wikiDataService;
    }
    private function setDriverId(string $name): void
    {
        $this->driverId = Drivers::where('driverRef', $name)
            ->value('driverId');
    }
    private function setDriverBasicData(): void
    {
        $this->driverBasicData = Drivers::where('driverId', $this->driverId)
            ->get();
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
        $driverId = $this->driverId;

        $totalRaces = Results::where('driverId', $driverId)
            ->count();

        $totalPodiums = Results::where('driverId', $driverId)
            ->whereBetween('results.positionText', [1, 3])
            ->count();

        $totalWins = Results::where('driverId', $driverId)
            ->where('results.positionText', '1')
            ->count();

        $totalPoles = Results::where('driverId', $driverId)
            ->where('results.grid', '1')
            ->count();

        $totalPoles = Results::where('driverId', $driverId)
            ->where('results.grid', '1')
            ->count();

        $totalLaps = Results::where('driverId', $driverId)
            ->sum('laps');

        // Calculating total points from results and sprintresults
        $totalRacePoints = Results::where('driverId', $driverId)->sum('points');
        $totalSprintPoints = Sprintresults::where('driverId', $driverId)->sum('points');

        $totalPoints = $totalRacePoints + $totalSprintPoints;

        $mergedStats = [
            'totalRaces' => $totalRaces,
            'totalWins' => $totalWins,
            'totalPodiums' => $totalPodiums,
            'totalPoles' => $totalPoles,
            'totalPoints' => $totalPoints,
            'totalLaps' => $totalLaps,
        ];

        $this->driverRaceStats = $mergedStats;
    }
    public function setActiveSeasons() : void
    {
        $totalSeaons = Results::select('races.year')
            ->where('results.driverId', $this->driverId)
            ->join('races', 'results.raceId', '=', 'races.raceId')
            ->groupBy('races.year')
            ->get();

        $this->driverTotalSeasons = collect($totalSeaons);
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
                'driver' => $this->driverBasicData->first(),
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
