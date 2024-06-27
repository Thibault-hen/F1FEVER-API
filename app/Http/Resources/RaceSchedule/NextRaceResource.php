<?php

namespace App\Http\Resources\RaceSchedule;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NextRaceResource extends JsonResource
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
            'date' => $this->date,
            'time' => $this->time,
            'wikipedia_link' => $this->url,
            'location' => $this->location,
            'country' => $this->country,
            'circuit_lat' => $this->lat,
            'circuit_lng' => $this->lng,
            'circuit_alt' => $this->alt
        ];
    }
}
