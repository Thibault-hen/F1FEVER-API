<?php

namespace App\Repositories\Circuits;

use App\Http\Resources\Circuits\CircuitResource;
use App\Models\Circuits;
use App\Models\Races;
use Illuminate\Support\Collection;

class CircuitRepository
{
    protected int $circuitId;
    protected Circuits $circuitBasicData;
    protected ?Collection $circuitRaceStats = null;
    protected ?Races $circuitFirstRace = null;
    protected ?Races $circuitLastRace = null;
    protected Collection $circuitRacesList;
    
    /**
     * Set the correct raceId with the given circuit reference
     * 
     * @param string $name
     * @return void
     */
    private function setCircuitId(string $name): void
    {
        $this->circuitId = Circuits::where('circuitRef', $name)
            ->value('circuitId');
    }

    /**
     * Retrieve and set circuit information for the current circuitId
     * 
     * @return void
     */
    private function setCircuitBasicData(): void
    {
        $this->circuitBasicData = Circuits::find($this->circuitId);
    }

    /**
     * Retrieve and set circuit race stats for the current driverId
     * 
     * @return void
     */
    private function setCircuitRaceStats(): void
    {
        $totalRaces = Races::where('circuitId', $this->circuitId)
            ->count();

        $this->circuitRaceStats = collect([
            'totalRaces' => $totalRaces
        ]);
    }

    /**
     * Retrieve and set circuit first race information for the current circuitId
     * 
     * @return void
     */
    private function setCircuitFirstRace(): void
    {
        $this->circuitFirstRace = Races::where('races.circuitId', $this->circuitId)
            ->join('circuits', 'races.circuitId', 'circuits.circuitId')
            ->orderBy('year', 'asc')
            ->select('races.name as gp_name', 'races.*', 'circuits.*')
            ->first();
    }

    /**
     * Retrieve and set circuit last race information for the current circutId
     * 
     * @return void
     */
    private function setCircuitLastRace(): void
    {
        $this->circuitLastRace = Races::where('races.circuitId', $this->circuitId)
            ->join('circuits', 'races.circuitId', 'circuits.circuitId')
            ->orderByDesc('year')
            ->select('races.name as gp_name', 'races.*', 'circuits.*')
            ->first();
    }

    /**
     * Retrieve and set circuit races list for the current circuitId
     * 
     * @return void
     */
    private function setCircuitRacesList(): void
    {
        $this->circuitRacesList = Races::join('circuits', 'races.circuitId', 'circuits.circuitId')
            ->where('races.circuitId', $this->circuitId)
            ->orderByDesc('year')
            ->select('races.name as gp_name', 'races.*', 'circuits.*')
            ->get();
    }

    /**
     * Retrieve and compile circuit data with the given circuit reference 
     * 
     * @param string $name
     * @return CircuitResource
     */
    public function getCircuitData(string $name): CircuitResource
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
