<?php

namespace App\Repositories\RaceReport;

use App\Exceptions\InvalidRaceReportException;
use App\Http\Resources\RaceReport\RaceReportResource;
use App\Models\Drivers;
use App\Models\Races;
use App\Models\Results;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RaceReportRepository
{
    protected Collection $raceInformation;
    protected Collection $lapTimes;
    protected int $driverId;
    protected int $raceId;


    /**
     * Retrieve the correct driverId with the given driver reference
     * 
     * @param string $driver
     * @return void
     */
    private function setDriverId(string $driver): void
    {
        $this->driverId = Drivers::where('driverRef', $driver)
            ->value('driverId');
    }

    /**
     * Retrieve the correct raceId with the given season and grand prix name
     * 
     * @param int season
     * @param string $gpName
     * @return void
     * @throws InvalidRaceReportException if there is no grand prix found for the given season
     */
    private function setRaceId(int $season, string $gpName): void
    {
        $raceId = Races::where('name', $gpName)
            ->where('year', $season)
            ->value('raceId');

        if (is_null($raceId)) {
            throw new InvalidRaceReportException('Cannot found this Grand Prix for the ' . $season . ' season');
        }

        $this->raceId = $raceId;
    }

    /**
     * Retrieve all the basic information about the race with the current driver and raceId
     * 
     * @return void
     * @throws InvalidRaceReportException if the driver has not participated in this grand prix or the data are not available for this season
     */
    private function setRaceInformation(): void
    {
        $raceResult = Results::with([
            'qualifying' => function ($query) {
                $query->where('driverId', $this->driverId);
            },
            'drivers',
            'races',
        ])
            ->where('raceId', $this->raceId)
            ->where('driverId', $this->driverId)
            ->first();


        if (!$raceResult) {
            throw new InvalidRaceReportException('This driver has not participated in this Grand Prix or the data are not available for this season');
        }

        $raceResult = [
            'race_name' => $raceResult->races,
            'race_results' => [
                'grid' => $raceResult->grid,
                'positionText' => $raceResult->positionText,
                'points' => $raceResult->points,
                'laps' => $raceResult->laps,
                'time' => $raceResult->time,
            ],
            'quali_results' => $raceResult->qualifying,
            'driver_name' => $raceResult->drivers,
        ];

        $this->raceInformation = collect($raceResult);
    }

    /**
     * Retrieve the lap times for the current driver and raceId
     * 
     * @return void
     */
    private function setRaceLapTimes(): void
    {
        $lapTimesResult = DB::table('laptimes')
            ->select('*')
            ->where('raceId', $this->raceId)
            ->where('driverId', $this->driverId)
            ->get();

        $pitstopsResult = DB::table('pitstops')
            ->select('*')
            ->where('raceId', $this->raceId)
            ->where('driverId', $this->driverId)
            ->get();

        $result = [
            'laps' => $lapTimesResult,
            'pitstops' => $pitstopsResult
        ];

        $this->lapTimes = collect($result);
    }

    /**
     * Retrieve and compile race report data for the given season, grand prix name and driver reference
     * 
     * @param int $season
     * @param string $gpName
     * @param string @driver
     * @return RaceReportResource
     */
    public function getRaceReport(int $season, string $gpName, string $driver): RaceReportResource
    {
        $this->setDriverId($driver);
        $this->setRaceId($season, $gpName);

        $this->setRaceInformation();
        $this->setRaceLapTimes();

        return new RaceReportResource([
            'raceInfo' => $this->raceInformation,
            'lapTimes' => $this->lapTimes
        ]);
    }
}