<?php

namespace App\Http\Resources\GrandPrix;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QualiResultResource extends JsonResource
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
            "q1 Time" => $this->q1 ?? 'N/A',
            "q2 Time" => $this->q2 ?? 'N/A',
            "q3 Time" => $this->q3 ?? 'N/A',
            "Position" => (string) $this->position
        ];
    }
}
