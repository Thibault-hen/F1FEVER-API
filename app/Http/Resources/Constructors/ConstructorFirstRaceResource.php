<?php

namespace App\Http\Resources\Constructors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class ConstructorFirstRaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'year' => (string)$this->first_race_year,
            'name' => $this->name,
            'country' => $this->country,
            'slug' => Str::slug($this->name) . '/' . $this->first_race_year
        ];
    }
}
