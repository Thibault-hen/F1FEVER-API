<?php

namespace App\Repositories\Circuits;

use App\Http\Resources\Circuits\CircuitResource;
use App\Models\Circuits;
use App\Models\Races;

class CircuitRepository
{
    protected $circuitId;
    protected $circuitBasicData;
    protected $circuitRaceStats;
    protected $circuitFirstRace;
    protected $circuitLastRace;
    protected $circuitRacesList;
    private function setCircuitId(string $name): void
    {
        $this->circuitId = Circuits::where('circuitRef', $name)
            ->value('circuitId');
    }

    private function setCircuitBasicData() : void
    {
        $this->circuitBasicData = Circuits::where('circuitId', $this->circuitId)
            ->get();
    }
    private function setCircuitRaceStats() : void
    {
        $totalRaces = Races::where('circuitId', $this->circuitId)
            ->count();

        $this->circuitRaceStats = [
            'totalRaces' => $totalRaces
        ];
    }

    private function setCircuitFirstRace() : void
    {
        $this->circuitFirstRace = Races::where('races.circuitId', $this->circuitId)
            ->join('circuits', 'races.circuitId', 'circuits.circuitId')
            ->orderByDesc('races.year')
            ->select('races.name as gp_name', 'races.*', 'circuits.*')
            ->first();
    }

    private function setCircuitLastRace() : void
    {
        $this->circuitLastRace = Races::where('races.circuitId', $this->circuitId)
            ->join('circuits', 'races.circuitId', 'circuits.circuitId')
            ->orderBy('year', 'asc')
            ->select('races.name as gp_name', 'races.*', 'circuits.*')
            ->first();
    }

    private function setCircuitRacesList() : void
    {
        $this->circuitRacesList = Races::join('circuits', 'races.circuitId', 'circuits.circuitId')
            ->where('races.circuitId', $this->circuitId)
            ->orderByDesc('year')
            ->select('races.name as gp_name', 'races.*', 'circuits.*')
            ->get();
    }

    public function getCircuitData(string $name) : CircuitResource
    {
        $this->setCircuitId($name);

        $this->setCircuitBasicData();
        $this->setCircuitRacesList();
        $this->setCircuitFirstRace();
        $this->setCircuitLastRace();
        $this->setCircuitRaceStats();

        return new CircuitResource([
            'basicData' => $this->circuitBasicData,
            'firstRaceEntered' => $this->circuitFirstRace,
            'lastRaceEntered' => $this->circuitLastRace,
            'raceStats' => $this->circuitRaceStats,
            'racesList' => $this->circuitRacesList
        ]);
    }
}
