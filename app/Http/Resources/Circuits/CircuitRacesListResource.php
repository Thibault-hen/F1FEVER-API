<?php

namespace App\Http\Resources\Circuits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CircuitRacesListResource extends JsonResource
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
            'season' => (string) $this->year,
            'date' => $this->date,
            'time' => $this->time,
            'slug' => Str::slug($this->gp_name) . '/' . $this->year
        ];
    }
}
