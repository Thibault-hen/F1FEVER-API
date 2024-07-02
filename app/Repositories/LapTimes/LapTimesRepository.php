<?php

namespace App\Repositories\LapTimes;

use App\Exceptions\InvalidLapTimesException;
use App\Http\Resources\LapTimes\LapTimesResource;
use App\Models\Drivers;
use App\Models\Races;
use Illuminate\Support\Facades\DB;

class LapTimesRepository
{
    protected $lapTimesResult;
    protected $driverInfo;
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
            throw new InvalidLapTimesException('Cannot found this Grand Prix for the ' . $season . ' season');
        }

        $this->raceId = $raceId;
    }

    private function setDriverInfo(): void
    {
        $this->driverInfo = Drivers::where('driverId', $this->driverId)
            ->get();
    }
    public function setLapTimesData(): void
    {
        $lapTimesResult = DB::table('laptimes')
            ->select('*')
            ->where('raceId', $this->raceId)
            ->where('driverId', $this->driverId)
            ->get();

        if ($lapTimesResult->isEmpty()) {
            throw new InvalidLapTimesException('This driver has not participated in this Grand Prix or the data are not available for this season');
        }

        $this->lapTimesResult = $lapTimesResult;
    }
    public function getLapTimes(int $season, string $gpName, string $driver): LapTimesResource
    {
        $this->setDriverId($driver);
        $this->setRaceId($season, $gpName);

        $this->setDriverInfo();
        $this->setLapTimesData();

        return new LapTimesResource([
            'driverInfo' => $this->driverInfo,
            'lapTimes' => $this->lapTimesResult
        ]);
    }
}