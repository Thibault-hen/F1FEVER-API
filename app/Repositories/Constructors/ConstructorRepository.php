<?php

namespace App\Repositories\Constructors;

use App\Http\Resources\Constructors\ConstructorResource;
use App\Models\Constructors;
use App\Models\ConstructorStandings;
use App\Models\Races;
use App\Models\Results;
use App\Models\Sprintresults;
use Illuminate\Support\Facades\DB;
use App\Services\WikiDataService;

class ConstructorRepository
{
    protected $constructorId;
    protected $wikiDataService;
    protected $constructorBasicData;
    protected $constructorFirstRace = [];
    protected $constructorLastRace = [];
    protected $constructorWikiImg;
    protected $constructorRaceStats;
    protected $constructorTotalSeasons;

    public function __construct(WikiDataService $wikiDataService)
    {
        $this->wikiDataService = $wikiDataService;
    }
    private function setConstructorId(string $name): void
    {
        $this->constructorId = Constructors::where('constructorRef', $name)
            ->value('constructorId');
    }
    private function setConstructorBasicData()
    {
        $this->constructorBasicData = Constructors::where('constructorId', $this->constructorId)
            ->get();
    }
    private function setConstructorFirstRace() : void
    {
        //Retrieving the first race year and round value in order to get the proper race name and country
        $firstRaceDate = Results::select(
            DB::raw('MIN(races.year) as first_race_year'),
            DB::raw('MIN(races.round) as first_race_round')
        )
            ->join('races', 'results.raceId', 'races.raceId')
            ->where('results.constructorId', $this->constructorId)
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
            $this->constructorFirstRace = $firstRaceData;
        }
    }
    private function setConstructorLastRace(): void
    {
        //Retrieving the first race year and round value in order to get the proper race name and country
        $lastRaceDate = ConstructorStandings::select(
            DB::raw('MAX(races.year) as last_race_year'),
            DB::raw('MAX(races.raceId) as last_race_id')
        )
            ->join('races', 'constructorStandings.raceId', 'races.raceId')
            ->where('constructorStandings.constructorId', $this->constructorId)
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
            $this->constructorLastRace = $lastRaceData;
        }
    }
    private function setRaceStats(): void
    {
        $constructorId = $this->constructorId;

        $totalRaces = Results::where('constructorId', $constructorId)
            ->distinct('raceId')
            ->count();

        $totalPodiums = Results::where('constructorId', $constructorId)
            ->whereBetween('results.positionText', [1, 3])
            ->count();

        $totalWins = Results::where('constructorId', $constructorId)
            ->where('results.positionText', '1')
            ->count();

        $totalPoles = Results::where('constructorId', $constructorId)
            ->where('results.grid', '1')
            ->count();

        $totalPoles = Results::where('constructorId', $constructorId)
            ->where('results.grid', '1')
            ->count();

        $totalLaps = Results::where('constructorId', $constructorId)
            ->sum('laps');

        // Calculating total points from results and sprintresults
        $totalRacePoints = Results::where('constructorId', $constructorId)->sum('points');
        $totalSprintPoints = Sprintresults::where('constructorId', $constructorId)->sum('points');

        $totalPoints = $totalRacePoints + $totalSprintPoints;

        $mergedStats = [
            'totalRaces' => $totalRaces,
            'totalWins' => $totalWins,
            'totalPodiums' => $totalPodiums,
            'totalPoles' => $totalPoles,
            'totalPoints' => $totalPoints,
            'totalLaps' => $totalLaps,
        ];

        $this->constructorRaceStats = $mergedStats;
    }
    public function setActiveSeasons() : void
    {
        $totalSeaons = Results::select('races.year')
            ->where('results.constructorId', $this->constructorId)
            ->join('races', 'results.raceId', '=', 'races.raceId')
            ->groupBy('races.year')
            ->get();

        $this->constructorTotalSeasons = collect($totalSeaons);
    }
    public function getConstructorData(string $name)
    {
        $this->setConstructorId($name);

        $this->setConstructorBasicData();
        $this->setRaceStats();
        $this->setConstructorFirstRace();
        $this->setConstructorLastRace();
        $this->setActiveSeasons();

        $this->wikiDataService->setWikiData($this->constructorBasicData->first()->url);
        $this->constructorWikiImg = $this->wikiDataService->getWikiImg();

        return new ConstructorResource([
            'basicData' => [
                'constructor' => $this->constructorBasicData->first(),
                'wikiImg' => $this->constructorWikiImg,
            ],
            'raceStats' => $this->constructorRaceStats,
            'firstRaceEntered' => $this->constructorFirstRace,
            'lastRaceEntered' => $this->constructorLastRace,
            'totalSeasons' => [
                "total" => $this->constructorTotalSeasons->count(),
                "year" => $this->constructorTotalSeasons->pluck('year'),
            ]
        ]);
    }
}
