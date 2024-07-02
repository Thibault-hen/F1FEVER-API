<?php

namespace App\Repositories\RaceReport;

use App\Exceptions\InvalidRaceReportException;
use App\Http\Resources\RaceReport\RaceReportResource;
use App\Models\Drivers;
use App\Models\Races;
use App\Models\Results;
use Illuminate\Support\Facades\DB;

class RaceReportRepository
{
    protected $raceInformation;
    protected $lapTimes;
    protected $driverId;
    protected $raceId;
    private function setDriverId(string $driver): void
    {
        $this->driverId = Drivers::where('driverRef', $driver)
            ->value('driverId');
    }

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

    private function setRaceInformation(): void
    {
        // Fetch only Results with required relationships
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


        if(!$raceResult){
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

        $this->raceInformation = $raceResult;
    }

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

        $this->lapTimes = $result;
    }

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