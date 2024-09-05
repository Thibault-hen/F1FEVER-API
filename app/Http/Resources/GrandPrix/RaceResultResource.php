<?php

namespace App\Http\Resources\GrandPrix;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaceResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this['forename'] . ' ' . $this['surname'],
            'nationality' => $this['nationality'],
            'team' => $this['team'],
            'team_nationality' => $this['teamNationality'],
            'time' => $this['time'] ?? null,
            'status' => stripos($this['status'], 'laps') !== false || stripos($this['status'], 'lap') !== false || $this['status'] === 'Finished' ? $this['status'] : 'DNF',
            'laps_completed' => (string) $this['laps'],
            'starting_position' => (string) $this['grid'],
            'final_position' => (string) $this['positionOrder']
        ];
    }
}
