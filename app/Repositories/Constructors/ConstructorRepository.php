<?php

namespace App\Repositories\Constructors;

use App\Http\Resources\Constructors\ConstructorResource;
use App\Models\Constructors;
use App\Models\ConstructorStandings;
use App\Models\Races;
use App\Models\Results;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Services\WikiDataService;

class ConstructorRepository
{
    protected int $constructorId;
    protected Constructors $constructorBasicData;
    protected ?Collection $constructorFirstRace = null;
    protected ?Collection $constructorLastRace = null;
    protected ?string $constructorWikiImg = null;
    protected Collection $constructorRaceStats;
    protected Collection $constructorTotalSeasons;

    public function __construct(
        protected WikiDataService $wikiDataService
    ) {
    }

    /**
     * Set the correct constructorId with the given constructor reference
     * 
     * @param string $name
     * @return void
     */
    private function setConstructorId(string $name): void
    {
        $this->constructorId = Constructors::where('constructorRef', $name)
            ->value('constructorId');
    }

    /**
     * Retrieve and set constructor information for the current constructorId
     * 
     * @return void
     */
    private function setConstructorBasicData(): void
    {
        $this->constructorBasicData = Constructors::find($this->constructorId);
    }

    /**
     * Retrieve and set constructor firt race information for the current constructorId
     * 
     * @return void
     */
    private function setConstructorFirstRace(): void
    {
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

    /**
     * Retrieve and set constructor last race information for the current constructorId
     * 
     * @return void
     */
    private function setConstructorLastRace(): void
    {
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

    /**
     * Retrieve and set constructor race stats for the current constructorId
     * 
     * @return void
     */
    private function setRaceStats(): void
    {
        $raceStats = Constructors::with('results', 'sprintResults')
            ->where('constructorId', $this->constructorId)
            ->get();

        $mergedStats = $raceStats->map(function ($result) {
            return [
                'totalRaces' => $result->results->unique('raceId')->count(),
                'totalPodiums' => $result->results->whereBetween('positionText', [1, 3])->count(),
                'totalWins' => $result->results->where('positionText', 1)->count(),
                'totalPoles' => $result->results->where('grid', 1)->count(),
                'totalPoints' => $result->results->sum('points') + $result->sprintResults->sum('points'),
                'totalLaps' => $result->results->sum('laps')
            ];
        });

        $this->constructorRaceStats = $mergedStats;
    }

    /**
     * Retrieve and set constructor total active seasons for the current constructorId
     * 
     * @return void
     */
    public function setActiveSeasons(): void
    {
        $totalSeaons = Results::select('races.year')
            ->where('results.constructorId', $this->constructorId)
            ->join('races', 'results.raceId', '=', 'races.raceId')
            ->groupBy('races.year')
            ->get();

        $this->constructorTotalSeasons = collect($totalSeaons);
    }

    /**
     * Retrieve and compile constructor data with the given constructor reference
     * 
     * @param $name
     * @return ConstructorResource
     */
    public function getConstructorData(string $name): ConstructorResource
    {
        $this->setConstructorId($name);

        $this->setConstructorBasicData();
        $this->setRaceStats();
        $this->setConstructorFirstRace();
        $this->setConstructorLastRace();
        $this->setActiveSeasons();

        $this->wikiDataService->setWikiData($this->constructorBasicData->url);
        $this->constructorWikiImg = $this->wikiDataService->getWikiImg();

        return new ConstructorResource([
            'basicData' => [
                'constructor' => $this->constructorBasicData,
                'wikiImg' => $this->constructorWikiImg,
            ],
            'raceStats' => $this->constructorRaceStats,
            'firstRaceEntered' => $this->constructorFirstRace,
            'lastRaceEntered' => $this->constructorLastRace,
            'totalSeasons' => [
                "total" => $this->constructorTotalSeasons->count(),
                "year" => $this->constructorTotalSeasons,
            ]
        ]);
    }
}
