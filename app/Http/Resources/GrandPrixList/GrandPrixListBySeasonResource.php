<?php

namespace App\Http\Resources\GrandPrixList;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GrandPrixListBySeasonResource extends JsonResource
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
            "Location" => $this->location,
            "Country" => $this->country,
            "Time" => $this->time,
            "Date" => $this->date
        ];
    }
}
