<?php

namespace App\Http\Resources\Circuits;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AllCircuitsResource extends JsonResource
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
            'wikipedia_link' => $this->url,
            'slug' => Str::slug($this->circuitRef)
        ];
    }
}
