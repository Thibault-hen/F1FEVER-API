<?php

namespace App\Http\Resources\GrandPrixList;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

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
            'name' => $this->name,
            'location' => $this->location,
            'country' => $this->country,
            'time' => $this->time,
            'date' => $this->date, 
            'slug' => Str::slug($this->name)
        ];
    }
}
