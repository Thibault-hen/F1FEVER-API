<?php

namespace App\Http\Resources\GrandPrix;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaceWinnerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->fullname,
            'nationality' => $this->nationality,
            'team' => $this->constructors,
            'time' => $this->time
        ];
    }
}
