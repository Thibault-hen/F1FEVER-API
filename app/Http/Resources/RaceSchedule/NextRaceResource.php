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
            "Name" => $this->name,
            "Date" => $this->date,
            "Time" => $this->time,
            "Wikipedia link" => $this->url,
            "Location" => $this->location,
            "Country" => $this->country,
            "Circuit lat" => $this->lat,
            "Circuit lng" => $this->lng,
            "Circuit alt" => $this->alt
        ];
    }
}
