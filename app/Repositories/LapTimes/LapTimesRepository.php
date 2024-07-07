<?php

namespace App\Repositories\LapTimes;

use App\Exceptions\InvalidLapTimesException;
use App\Http\Resources\LapTimes\LapTimesResource;
use App\Models\Drivers;
use App\Models\Races;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class LapTimesRepository
{
    protected Collection $lapTimesResult;
    protected Collection $driverInfo;
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
     * @throws InvalidLapTimesException if there is no grand prix found for the given season
     */
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

    /**
     * Retrieve the driver information for the current driverId
     * 
     * @return void
     */
    private function setDriverInfo(): void
    {
        $this->driverInfo = Drivers::where('driverId', $this->driverId)
            ->get();
    }

    /**
     * Retrieve the lap times for the current driver and race Id
     * 
     * @return void
     * @throws InvalidLapTimesException if the driver has not participated in this grand prix or the data are not available for this season
     */
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

    /**
     * Retrieve and compile the lap times data with the given season, grand prix name and driver reference
     * 
     * @param int $season
     * @param string $gpName
     * @param string $driver
     * @return LapTimesResource
     */
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