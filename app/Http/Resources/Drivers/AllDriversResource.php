<?php

namespace App\Http\Resources\Drivers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AllDriversResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->forename . " " . $this->surname,
            'nationality' => $this->nationality,
            'date_of_birth' => $this->dob,
            'wikipedia_link' => $this->url,
            'number' => (string) $this->number ?? "N/A",
            'slug' => Str::slug($this->driverRef)
        ];
    }
}
