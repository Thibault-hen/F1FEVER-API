<?php

namespace App\Http\Resources\RaceReport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaceReportResultsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'starting_position' => (string) $this['grid'],
            'final_position' => $this['positionText'],
            'points_scored' => (string) $this['points'],
            'laps' => (string) $this['laps'],
            'time' => $this['time'] ?? 'N/A'
        ];
    }
}
