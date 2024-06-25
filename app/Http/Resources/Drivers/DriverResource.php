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
            'Driver Information' => new DriverInformationResource($this->resource['basicData']),
            'Race Stats' => new DriverRaceStatsResource($this->resource['raceStats']),
            'First Race Entered' => DriverFirstRaceResource::collection($this->resource['firstRaceEntered']),
            'Last Race Entered' => DriverLastRaceResource::collection($this->resource['lastRaceEntered']),
            'Total active seasons' => new DriverActiveSeasonsResource($this->resource['totalSeasons']),
        ];
    }
}
