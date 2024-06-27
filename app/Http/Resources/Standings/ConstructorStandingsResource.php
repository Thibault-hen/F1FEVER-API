<?php

namespace App\Http\Resources\Standings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConstructorStandingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'nationality' => $this->nationality,
            'position' => (string) $this->position,
            'wins' => (string) $this->wins,
            'points' => (string) $this->points,
            'gap' => (string) $this->points_gap
        ];
    }
}
