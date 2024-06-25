<?php

namespace App\Repositories\Circuits;

use App\Models\Circuits;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Circuits\AllCircuitsResource;
use App\Http\Resources\Circuits\AllCircuitsBySeasonResource;

class CircuitListRepository
{
    public function getAllCircuits(): ResourceCollection
    {
        return AllCircuitsResource::collection(Circuits::all());
    }
    public function getAllCircuitsBySeason(int $season): ResourceCollection
    {
        $circuits = Circuits::join("races", "races.circuitId", "circuits.circuitId")
            ->where("races.year", $season)
            ->get();

        return AllCircuitsBySeasonResource::collection($circuits);
    }
}
