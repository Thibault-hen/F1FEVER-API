<?php

namespace App\Http\Resources\GrandPrixPreview;

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
            'starting_position' => (string) $this->grid,
            'name' => $this->fullname,
            'nationality' => $this->nationality,
            'time' => $this->time,
        ];
    }
}
