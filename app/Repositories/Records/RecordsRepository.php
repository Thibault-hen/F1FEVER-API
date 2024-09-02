<?php

namespace App\Repositories\Records;
use App\Http\Resources\Records\ConstructorsRecordsResource;
use App\Http\Resources\Records\DriversRecordsResource;
use App\Models\Constructors;
use App\Models\Drivers;

class RecordsRepository
{
    private array $driversRecords;
    private array $constructorsRecords;
    public function setDriversRecords(): void
    {
        // Retrieve drivers with their related results, qualifying, and sprintResults
        $drivers = Drivers::with('results', 'qualifying', 'sprintResults')
            ->get();

        // Map each driver to their aggregated statistics
        $driversWithStats = $drivers->map(function ($driver) {
            return [
                'name' => $driver->forename . ' ' . $driver->surname,
                'nationality' => $driver->nationality,
                'wins_percentage' => round(($driver->results->where('positionText', '1')->count() / $driver->results->count()) * 100, 2),
                'wins' => $driver->results->where('positionText', '1')->count(),
                'podiums' => $driver->results->whereBetween('positionText', [1, 3])->count(),
                'poles' => $driver->qualifying->where('position', '1')->count(),
                'laps' => $driver->results->sum('laps'),
                'points' => $driver->results->sum('points'),
                'sprints' => $driver->sprintResults->where('positionText', '1')->count()
            ];
        });
        // Function to get the driver with the maximum value for a specific metric
        $getTopDriverByMetric = function ($metric) use ($driversWithStats) {
            $maxValue = $driversWithStats->max($metric);
            return $driversWithStats->firstWhere($metric, $maxValue);
        };

        $driverMaxWins = $getTopDriverByMetric('wins');
        $driverMaxWinsPercentage = $getTopDriverByMetric('wins_percentage');
        $driverMaxPodiums = $getTopDriverByMetric('podiums');
        $driverMaxPoles = $getTopDriverByMetric('poles');
        $driverMaxLaps = $getTopDriverByMetric('laps');
        $driverMaxPoints = $getTopDriverByMetric('points');
        $driverMaxSprints = $getTopDriverByMetric('sprints');

        // Prepare results with relevant data only
        $result = [
            'total_wins' => $driverMaxWins ? [
                'name' => $driverMaxWins['name'],
                'nationality' => $driverMaxWins['nationality'],
                'wins' => $driverMaxWins['wins'],
            ] : null,
            'wins_percentage' => $driverMaxWinsPercentage ? [
                'name' => $driverMaxWinsPercentage['name'],
                'nationality' => $driverMaxWinsPercentage['nationality'],
                'percentage' => $driverMaxWinsPercentage['wins_percentage'],
            ] : null,
            'total_podiums' => $driverMaxPodiums ? [
                'name' => $driverMaxPodiums['name'],
                'nationality' => $driverMaxPodiums['nationality'],
                'podiums' => $driverMaxPodiums['podiums']
            ] : null,
            'total_poles' => $driverMaxPoles ? [
                'name' => $driverMaxPoles['name'],
                'nationality' => $driverMaxPoles['nationality'],
                'poles' => $driverMaxPoles['poles']
            ] : null,
            'total_laps' => $driverMaxLaps ? [
                'name' => $driverMaxLaps['name'],
                'nationality' => $driverMaxLaps['nationality'],
                'laps' => $driverMaxLaps['laps']
            ] : null,
            'total_points' => $driverMaxPoints ? [
                'name' => $driverMaxPoints['name'],
                'nationality' => $driverMaxPoints['nationality'],
                'points' => $driverMaxPoints['points']
            ] : null,
            'total_sprints' => $driverMaxSprints ? [
                'name' => $driverMaxSprints['name'],
                'nationality' => $driverMaxSprints['nationality'],
                'sprints' => $driverMaxSprints['sprints']
            ] : null,
        ];

        $this->driversRecords = $result;
    }

    public function setConstructorsRecords(): void
    {
        // Retrieve drivers with their related results, qualifying, and sprintResults
        $constructors = Constructors::with('results', 'qualifying', 'sprintResults')
            ->get();

        // Map each constructor to their aggregated statistics
        $constructorsWithStats = $constructors->map(function ($constructor) {
            return [
                'name' => $constructor->name,
                'nationality' => $constructor->nationality,
                'wins' => $constructor->results->where('positionText', '1')->count(),
                'podiums' => $constructor->results->whereBetween('positionText', [1, 3])->count(),
                'laps' => $constructor->results->sum('laps'),
                'points' => $constructor->results->sum('points'),
                'sprints' => $constructor->sprintResults->where('positionText', '1')->count()
            ];
        });

        // Function to get the constructor with the maximum value for a specific metric
        $getTopconstructorByMetric = function ($metric) use ($constructorsWithStats) {
            $maxValue = $constructorsWithStats->max($metric);
            return $constructorsWithStats->firstWhere($metric, $maxValue);
        };

        $constructorMaxWins = $getTopconstructorByMetric('wins');
        $constructorMaxPodiums = $getTopconstructorByMetric('podiums');
        $constructorMaxLaps = $getTopconstructorByMetric('laps');
        $constructorMaxPoints = $getTopconstructorByMetric('points');
        $constructorMaxSprints = $getTopconstructorByMetric('sprints');

        // Prepare results with relevant data only
        $result = [
            'total_wins' => $constructorMaxWins ? [
                'name' => $constructorMaxWins['name'],
                'nationality' => $constructorMaxWins['nationality'],
                'wins' => $constructorMaxWins['wins'],
            ] : null,
            'total_podiums' => $constructorMaxPodiums ? [
                'name' => $constructorMaxPodiums['name'],
                'nationality' => $constructorMaxPodiums['nationality'],
                'podiums' => $constructorMaxPodiums['podiums']
            ] : null,
            'total_laps' => $constructorMaxLaps ? [
                'name' => $constructorMaxLaps['name'],
                'nationality' => $constructorMaxLaps['nationality'],
                'laps' => $constructorMaxLaps['laps']
            ] : null,
            'total_points' => $constructorMaxPoints ? [
                'name' => $constructorMaxPoints['name'],
                'nationality' => $constructorMaxPoints['nationality'],
                'points' => $constructorMaxPoints['points']
            ] : null,
            'total_sprints' => $constructorMaxSprints ? [
                'name' => $constructorMaxSprints['name'],
                'nationality' => $constructorMaxSprints['nationality'],
                'sprints' => $constructorMaxSprints['sprints']
            ] : null,
        ];

        $this->constructorsRecords = $result;
    }

    public function getDriversRecords(): DriversRecordsResource
    {
        return new DriversRecordsResource($this->driversRecords);
    }
    public function getConstructorsRecords(): ConstructorsRecordsResource
    {
        return new ConstructorsRecordsResource($this->constructorsRecords);
    }
}