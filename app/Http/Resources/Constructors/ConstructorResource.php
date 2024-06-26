<?php

namespace App\Http\Resources\Constructors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConstructorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Constructor Information' => new ConstructorInformationResource($this->resource['basicData']),
            'Race Stats' => new ConstructorRaceStatsResource($this->resource['raceStats']),
            'First Race Entered' => ConstructorFirstRaceResource::collection($this->resource['firstRaceEntered']),
            'Last Race Entered' => ConstructorLastRaceResource::collection($this->resource['lastRaceEntered']),
            'Total active seasons' => new ConstructorActiveSeasonsResource($this->resource['totalSeasons']),
        ];
    }
}
