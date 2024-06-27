<?php

namespace App\Http\Resources\Circuits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CircuitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'circuit_info' => CircuitInformationResource::collection($this->resource['basicData']),
            'race_stats' => new CircuitRaceStatsResource($this->resource['raceStats']),
            'first_race_entered' => new CircuitFirstRaceResource($this->resource['firstRaceEntered']),
            'last_race_entered' => new CircuitLastRaceResource($this->resource['lastRaceEntered']),
            'races_list' => CircuitRacesListResource::collection($this->resource['racesList']),
        ];
    }
}
