<?php

namespace App\Http\Resources\Drivers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'driver_info' => new DriverInformationResource($this->resource['basicData']),
            'race_stats' => new DriverRaceStatsResource($this->resource['raceStats']),
            'first_race_entered' => DriverFirstRaceResource::collection($this->resource['firstRaceEntered']),
            'last_race_entered' => DriverLastRaceResource::collection($this->resource['lastRaceEntered']),
            'total_active_seasons' => new DriverActiveSeasonsResource($this->resource['totalSeasons']),
        ];
    }
}
