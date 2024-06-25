<?php

namespace App\Http\Resources\Constructors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AllConstructorsBySeasonResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "Name" => $this->name,
            "Nationality" => $this->nationality,
            "Wikipedia link" => $this->url
        ];
    }
}
