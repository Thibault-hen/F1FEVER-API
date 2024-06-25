<?php

namespace App\Repositories\GrandPrix;

use App\Exceptions\InvalidGrandPrixException;
use App\Http\Resources\GrandPrix\GrandPrixResource;
use App\Http\Resources\MimifiedGrandPrix\MimifiedGrandPrixResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use App\Models\Races;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GrandPrixRepository
{

    protected Collection $raceResult;
    protected Collection $qualiResult;
    protected $raceWinner;
    protected $poleMan = [];
    protected $circuit;
    protected int $raceId;
    public function getGrandPrixData(string $name, int $season): GrandPrixResource
    {
        //Initializing the correct grand prix by searching for his raceId with his name and season
        $this->setRaceId($name, $season);

        //Collecting various data about the grand prix using the raceId
        $this->setRaceResultData();
        $this->setQualiResultData();

        $this->setRaceWinner();
        $this->setPoleman();
        $this->setCircuit();

        return new GrandPrixResource([
            "raceResult" => $this->raceResult,
            "qualiResult" => $this->qualiResult,
            "raceWinner" => $this->raceWinner,
            "poleMan" => $this->poleMan,
            "circuit" => $this->circuit
        ]);
    }

    public function getMimifiedGrandPrixData(string $name, int $season): MimifiedGrandPrixResource
    {
        $this->setRaceId($name, $season);
        $this->setRaceResultData();
        $this->setCircuit();

        return new MimifiedGrandPrixResource([
            "raceResult" => $this->raceResult->take(10),
            "circuit" => $this->circuit
        ]);
    }

    private function setRaceId(string $name, int $season): void
    {
        $raceId = Races::where("name", $name)
            ->where("year", $season)
            ->value("raceid");

        if (is_null($raceId)) {
            throw new InvalidGrandPrixException("Not race found for this season");
        }

        $this->raceId = $raceId;
    }
    private function setRaceResultData(): void
    {
        $raceResult = DB::table('results')
            ->select(
                'results.grid',
                'results.laps',
                'results.time',
                'results.positionOrder',
                DB::raw("CONCAT(drivers.forename, ' ',  drivers.surname) as fullname"),
                'constructors.name as constructors',
                'drivers.nationality',
                'status.status',
                'races.year'
            )
            ->join('drivers', 'results.driverId', '=', 'drivers.driverId')
            ->join('constructors', 'results.constructorId', '=', 'constructors.constructorId')
            ->join('status', 'results.statusId', '=', 'status.statusId')
            ->join('races', 'results.raceId', '=', 'races.raceId')
            ->where('results.raceId', $this->raceId)
            ->groupBy(
                'results.grid',
                'results.laps',
                'results.time',
                'results.positionOrder',
                'fullname',
                'constructors',
                'drivers.nationality',
                'status.status',
                'races.year'
            )
            ->orderBy('results.positionOrder')
            ->get();

        $this->raceResult = $raceResult;
    }
    private function setQualiResultData(): void
    {
        $raceId = $this->raceId;
        $qualiResult = DB::table('results')
            ->select(
                DB::raw("CONCAT(drivers.forename, ' ', drivers.surname) as fullname"),
                'drivers.number',
                'drivers.nationality',
                'constructors.name as constructors',
                'qualifying.position',
                'qualifying.q1',
                'qualifying.q2',
                'qualifying.q3'
            )
            ->join('drivers', 'results.driverId', '=', 'drivers.driverId')
            ->join('constructors', 'results.constructorId', '=', 'constructors.constructorId')
            ->join('qualifying', function ($join) use ($raceId) {
                $join->on('results.raceId', '=', 'qualifying.raceId')
                    ->on('results.driverId', '=', 'qualifying.driverId');
            })
            ->join('races', 'results.raceId', '=', 'races.raceId')
            ->where('results.raceId', $raceId)
            ->groupBy(
                'fullname',
                'drivers.number',
                'drivers.nationality',
                'constructors.name',
                'qualifying.position',
                'qualifying.q1',
                'qualifying.q2',
                'qualifying.q3'
            )
            ->orderBy('qualifying.position')
            ->get();

        $this->qualiResult = $qualiResult;
    }
    private function setRaceWinner(): void
    {
        $this->raceWinner = collect($this->raceResult)
            ->filter(fn ($result) => !is_null($result->time))
            ->sortBy("positionOrder")
            ->first();
    }

    private function setPoleman(): void
    {
        $this->poleMan = collect($this->qualiResult)
            ->filter(fn ($result) => !is_null($result->q3))
            ->sortBy("q3")
            ->first();

        if (is_null($this->poleMan)) {
            $this->poleMan = collect($this->qualiResult)
                ->filter(fn ($result) => !is_null($result->q1))
                ->sortBy("q1")
                ->first();
        }
    }

    private function setCircuit(): void
    {
        $this->circuit = Races::join("Circuits", "races.circuitId", "=", "circuits.circuitId")
            ->where("races.raceId", $this->raceId)
            ->first();
    }
}
