<?php

namespace App\Repositories\Standings;

use App\Http\Resources\Standings\DriverStandingsResource;
use App\Http\Resources\Standings\ConstructorStandingsResource;
use App\Models\Drivers;
use App\Models\Constructors;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\DB;

class StandingsRepository
{
    /**
     * Retrieve the drivers standings with the given season
     * 
     * @param int season
     * @return ResourceCollection
     */
    public function drivers(int $season): ResourceCollection
    {

        return DriverStandingsResource::collection(Drivers::select(
            'drivers.driverId',
            'drivers.code',
            'drivers.nationality',
            'drivers.forename',
            'drivers.surname',
            'driverStandings.points',
            'driverStandings.position',
            'driverStandings.wins',
            'races.year',
            DB::raw('(MAX(driverStandings.points) OVER ()) - driverStandings.points AS points_gap')
        )
            ->join('driverStandings', 'drivers.driverId', '=', 'driverStandings.driverId')
            ->join('races', 'driverStandings.raceId', '=', 'races.raceId')
            ->where('races.year', $season)
            ->where('races.round', function ($query) use ($season) {
                $query->select(DB::raw('MAX(round)'))
                    ->from('driverStandings')
                    ->join('races', 'driverStandings.raceId', '=', 'races.raceId')
                    ->where('races.year', $season);
            })
            ->orderBy('driverStandings.position')
            ->get());
    }

    /**
     * Retrieve the constructors standings with the given season
     * 
     * @param int season
     * @return ResourceCollection
     */
    public function constructors(int $season): ResourceCollection
    {
        return ConstructorStandingsResource::collection(Constructors::select(
            'constructors.name',
            'constructors.nationality',
            'constructorStandings.points',
            'constructorStandings.position',
            'constructorStandings.wins',
            DB::raw('(MAX(constructorStandings.points) OVER ()) - constructorStandings.points AS points_gap')
        )
            ->join('constructorStandings', 'constructors.constructorId', '=', 'constructorStandings.constructorId')
            ->join('races', 'constructorStandings.raceId', '=', 'races.raceId')
            ->where('races.year', $season)
            ->where('races.round', function ($query) use ($season) {
                $query->select(DB::raw('MAX(round)'))
                    ->from('constructorStandings')
                    ->join('races', 'constructorStandings.raceId', '=', 'races.raceId')
                    ->where('races.year', $season);
            })
            ->orderBy('constructorStandings.position')
            ->get());
    }
}
