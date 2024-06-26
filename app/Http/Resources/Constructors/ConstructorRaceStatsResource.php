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
            'Total races' => (string) $this['totalRaces'],
            'Total podiums' => (string) $this['totalPodiums'],
            'Total wins' => (string) $this['totalWins'],
            'Total points' => (string) $this['totalPoints'],
            'Total poles' => (string) $this['totalPoles']
        ];
    }
}
