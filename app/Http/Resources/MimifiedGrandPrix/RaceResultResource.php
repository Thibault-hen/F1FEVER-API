<?php

namespace App\Http\Resources\MimifiedGrandPrix;

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
            "Starting position" => $this->grid,
            "Name" => $this->fullname,
            "Nationality" => $this->nationality,
            "Time" => $this->time,
        ];
    }
}
