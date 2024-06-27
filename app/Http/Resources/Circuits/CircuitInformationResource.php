<?php

namespace App\Http\Resources\Circuits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CircuitInformationResource extends JsonResource
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
            'location' => $this->location,
            'country' => $this->country,
            'lat' => (string) $this->lat,
            'lng' => (string) $this->lng,
            'alt' => (string) $this->alt,
            'wikipedia_link' => $this->url
        ];
    }
}
