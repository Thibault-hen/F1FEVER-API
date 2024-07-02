<?php

namespace App\Http\Resources\RaceReport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaceReportResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'race_info' => new RaceReportNameResource($this->resource['raceInfo']['race_name']),
            'race_results' => new RaceReportResultsResource($this->resource['raceInfo']['race_results']),
            'quali_results' => RaceReportQualiResultsResource::collection($this->resource['raceInfo']['quali_results']),
            'driver_info' => new RaceReportDriverNameResource($this->resource['raceInfo']['driver_name']),
            'lap_times' => RaceReportLaptimesResource::collection($this->resource['lapTimes']['laps']),
            'pitstops' => RaceReportPitstopsResource::collection($this->resource['lapTimes']['pitstops'])
        ];
    }
}
