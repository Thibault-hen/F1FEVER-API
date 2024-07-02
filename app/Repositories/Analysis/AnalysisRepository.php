<?php

namespace App\Repositories\Analysis;

use App\Http\Resources\Analysis\AnalysisDriversResource;
use App\Http\Resources\Analysis\AnalysisRacesResource;
use App\Http\Resources\Analysis\AnalysisSeasonsResource;
use App\Models\Races;
use App\Models\Results;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class AnalysisRepository
{
    /**
     * Get the list of available seasons for analysis data (lap times and race report).
     */
    public function getSeasonsList(): AnonymousResourceCollection
    {
        return AnalysisSeasonsResource::collection(Races::whereHas('laptimes')
            ->distinct()
            ->orderBy('year', 'asc')
            ->get('year'));
    }

    /**
     * Get the list of grand prix for a specific season.
     *
     * @param int $season The season year.
     */
    public function getGrandPrixList(int $season): AnonymousResourceCollection
    {
        return AnalysisRacesResource::collection(Races::select('name')
            ->where('year', $season)
            ->get());
    }

    /**
     * Get the list of drivers for a specific season and grand prix.
     *
     * @param int $season The season year.
     * @param string $gpName The name of the grand prix.
     */
    public function getDriversList(int $season, string $gpName): AnonymousResourceCollection
    {
        $results = Results::with('races', 'drivers')
            ->whereHas('races', function ($query) use ($season, $gpName) {
                $query->where('year', $season)
                    ->where('name', $gpName);
            })
            ->get();

        $driversList = $results->map(function ($result) {
            return [
                'forename' => $result->drivers->forename,
                'surname' => $result->drivers->surname,
                'ref' => $result->drivers->driverRef,
            ];
        });

        return AnalysisDriversResource::collection($driversList);
    }
}