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
            'constructor_info' => new ConstructorInformationResource($this->resource['basicData']),
            'race_stats' => ConstructorRaceStatsResource::collection($this->resource['raceStats']),
            'first_race_entered' => ConstructorFirstRaceResource::collection($this->resource['firstRaceEntered']),
            'last_race_entered' => ConstructorLastRaceResource::collection($this->resource['lastRaceEntered']),
            'total_active_seasons' => new ConstructorActiveSeasonsResource($this->resource['totalSeasons']),
        ];
    }
}
