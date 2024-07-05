<?php

namespace App\Http\Resources\Constructors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConstructorRaceStatsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total_races' => (string) $this['totalRaces'],
            'total_podiums' => (string) $this['totalPodiums'],
            'total_wins' => (string) $this['totalWins'],
            'total_points' => (string) $this['totalPoints'],
            'total_poles' => (string) $this['totalPoles'],
            'total_laps' => (string) $this['totalLaps'],
        ];
    }
}
