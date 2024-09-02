<?php

namespace App\Repositories\GrandPrix;

use App\Exceptions\InvalidGrandPrixException;
use App\Http\Resources\GrandPrix\GrandPrixResource;
use App\Http\Resources\GrandPrixPreview\GrandPrixPreviewResource;
use App\Models\Qualifying;
use App\Models\Results;
use Illuminate\Support\Collection;
use App\Models\Races;

class GrandPrixRepository
{
    protected Collection $raceResult;
    protected ?Collection $qualiResult = null;
    protected Races $raceName;
    protected Races $circuit;
    protected array $raceWinner;
    protected ?array $poleMan = null;
    protected int $raceId;

    /**
     * Retrieve and compile detailed Grand Prix data with the given grand prix name and season.
     *
     * @param string $name
     * @param int $season
     * @return GrandPrixResource
     */
    public function getGrandPrixData(string $name, int $season): GrandPrixResource
    {
        $this->setRaceId($name, $season);

        $this->setRaceName();
        $this->setRaceResult();
        $this->setQualiResult();

        $this->setRaceWinner();
        $this->setPoleman();
        $this->setCircuit();

        return new GrandPrixResource([
            'raceName' => $this->raceName,
            'raceResult' => $this->raceResult,
            'qualiResult' => $this->qualiResult,
            'raceWinner' => $this->raceWinner,
            'poleMan' => $this->poleMan,
            'circuit' => $this->circuit
        ]);
    }

    /**
     * Get a preview Grand Prix Data
     * 
     * @param string $name
     * @param int $season
     * @return GrandPrixPreviewResource
     */
    public function getGrandPrixPreviewData(string $name, int $season): GrandPrixPreviewResource
    {
        $this->setRaceId($name, $season);
        $this->setRaceName();
        $this->setRaceResult();
        $this->setCircuit();

        return new GrandPrixPreviewResource([
            'raceName' => $this->raceName,
            'raceResult' => $this->raceResult->take(10),
            'circuit' => $this->circuit
        ]);
    }
    /**
     * Set the correct raceId based on the name and season
     * 
     * @param string $name
     * @param int $season
     * @return void
     * @throws InvalidGrandPrixException if there is no race for this season
     */
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

    /**
     * Set the race name for the current race
     * 
     * @return void
     */
    private function setRaceName(): void
    {
        $this->raceName = Races::where('raceId', $this->raceId)
            ->first();
    }

    /**
     * Set race results data for the current race.
     *
     * @return void
     */
    private function setRaceResult(): void
    {
        $raceResults = Results::with(['drivers', 'constructors', 'status', 'races'])
            ->where('raceId', $this->raceId)
            ->orderBy('positionOrder')
            ->get();

        $raceResultsFormatted = $raceResults->map(function ($result) {
            return [
                'grid' => $result->grid,
                'laps' => $result->laps,
                'time' => $result->time,
                'positionOrder' => $result->positionOrder,
                'forename' => $result->drivers->forename,
                'surname' => $result->drivers->surname,
                'constructors' => $result->constructors->name,
                'nationality' => $result->drivers->nationality,
                'status' => $result->status->status,
                'year' => $result->races->year,
            ];
        });

        $this->raceResult = $raceResultsFormatted;
    }

    /**
     * Set qualifying results data for the current race.
     *
     * @return void
     */
    private function setQualiResult(): void
    {
        $raceId = $this->raceId;

        $qualiResult = Qualifying::with(['drivers', 'constructors', 'races'])
            ->where('raceId', $raceId)
            ->get();

        $qualiResultsFormatted = $qualiResult->map(function ($result) {
            return [
                'forename' => $result->drivers->forename,
                'surname' => $result->drivers->surname,
                'nationality' => $result->drivers->nationality,
                'team' => $result->constructors->name,
                'q1' => $result->q1,
                'q2' => $result->q2,
                'q3' => $result->q3,
                'position' => $result->position
            ];
        });

        $this->qualiResult = $qualiResultsFormatted;
    }

    /**
     * Set race winner data for the current race
     *
     * @return void
     */
    private function setRaceWinner(): void
    {
        $this->raceWinner = collect($this->raceResult)
            ->filter(fn($result) => !is_null($result['time']))
            ->sortBy("positionOrder")
            ->first();
    }

    /**
     * Set the correct poleman data between q1 and q3 times for the current race
     *
     * @return void
     */
    private function setPoleman(): void
    {
        $polemanWithQ3 = collect($this->qualiResult)
            ->filter(fn($result) => !empty ($result['q3']))
            ->sortBy("q3")
            ->first();

        if (is_null($polemanWithQ3)) {
            $polemanWithQ1 = collect($this->qualiResult)
                ->filter(fn($result) => !empty ($result['q1']))
                ->sortBy("q1")
                ->first();

            $this->poleMan = $polemanWithQ1;
        } else {
            $this->poleMan = $polemanWithQ3;
        }
    }

    /**
     * Set the circuit data for the current race
     *
     * @return void
     */
    private function setCircuit(): void
    {
        $this->circuit = Races::join("Circuits", "races.circuitId", "=", "circuits.circuitId")
            ->where("races.raceId", $this->raceId)
            ->first();
    }
}
