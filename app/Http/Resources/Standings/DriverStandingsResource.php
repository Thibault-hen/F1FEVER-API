<?php

namespace App\Http\Resources\Standings;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverStandingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "Name" => "{$this->forename} {$this->surname}",
            "Code" => $this->code,
            "Nationality" => $this->nationality,
            "Position" => $this->position,
            "Wins" => $this->wins,
            "Points" => $this->points,
            "Gap" => $this->points_gap
        ];
    }
}
