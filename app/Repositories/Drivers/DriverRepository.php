<?php

namespace App\Repositories\Drivers;

use App\Http\Resources\Drivers\DriverResource;
use App\Models\Drivers;
use App\Models\DriverStandings;
use App\Models\Races;
use App\Models\Results;
use App\Services\WikiDataService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class DriverRepository
{
    protected int $driverId;
    protected Drivers $driverBasicData;
    protected ?Collection $driverFirstRace = null;
    protected ?Collection $driverLastRace = null;
    protected ?Collection $driverRaceStats = null;
    protected ?Collection $driverTotalSeasons = null;
    protected ?string $driverWikiImg = null;

    public function __construct(
        protected WikiDataService $wikiDataService
    ) {
    }

    /**
     * Set the correct driverId with the given driver reference
     * 
     * @param string $driver
     * @return void
     */
    private function setDriverId(string $name): void
    {
        $this->driverId = Drivers::where('driverRef', $name)
            ->value('driverId');
    }

    /**
     * Retrieve and set driver information for the current driverId
     * 
     * @return void
     */
    private function setDriverBasicData(): void
    {
        $this->driverBasicData = Drivers::find($this->driverId);
    }

    /**
     * Retrieve and set driver first race information for the current driverId
     * 
     * @return void
     */
    private function setDriverFirstRace(): void
    {
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

    /**
     * Retrieve and set driver last race information for the current driverId
     * 
     * @return void
     */
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

    /**
     * Retrieve and set driver race stats for the current driverId
     * 
     * @return void
     */
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

    /**
     * Retrieve and set driver alla active seasons for the current driverId
     * 
     * @return void
     */
    public function setActiveSeasons(): void
    {
        $totalSeasons = Results::select('races.year')
            ->where('results.driverId', $this->driverId)
            ->join('races', 'results.raceId', '=', 'races.raceId')
            ->groupBy('races.year')
            ->get();

        $this->driverTotalSeasons = $totalSeasons;
    }

    /**
     * Retrieve and compile driver data with the given driver reference
     * 
     * @param string $name
     * @return DriverResource
     */
    public function getDriverData(string $name): DriverResource
    {
        $this->setDriverId($name);

        $this->setActiveSeasons();
        $this->setDriverBasicData();
        $this->setDriverFirstRace();
        $this->setDriverLastRace();
        $this->setRaceStats();

        $this->wikiDataService->setWikiData($this->driverBasicData->url);
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
                "year" => $this->driverTotalSeasons,
            ]
        ]);
    }
}
