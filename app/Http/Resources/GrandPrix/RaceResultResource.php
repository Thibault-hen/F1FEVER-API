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
            "Name" => $this->fullname,
            "Nationality" => $this->nationality,
            "Team" => $this->constructors,
            "Time" => $this->time,
            "Status" => $this->status === "Finished" ? $this->status : "DNF",
            "Laps completed" => $this->laps,
            "Starting position" => $this->grid,
            "Final Position" => $this->positionOrder
        ];
    }
}
