<?php

namespace App\Http\Resources\Drivers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllDriversBySeasonResource extends JsonResource
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
            "Date of birth" => $this->dob,
            "Wikipedia link" => $this->url,
            "Number" => $this->number ?? "N/A"
        ];
    }
}
