<?php

namespace App\Http\Resources\Circuits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class CircuitFirstRaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'season' => (string) $this->year,
            'name' => $this->gp_name,
            'location' => $this->location,
            'country' => $this->country,
            'slug' => Str::slug($this->gp_name) . '/' . $this->year
        ];
    }
}
