<?php

namespace App\Http\Resources\GrandPrix;

use App\Http\Resources\GrandPrix\RaceResultResource;
use App\Http\Resources\GrandPrix\QualiResultResource;
use App\Http\Resources\GrandPrix\RaceWinnerResource;
use App\Http\Resources\GrandPrix\PoleManResource;
use App\Http\Resources\GrandPrix\CircuitResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GrandPrixResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {    
        return [
            'Race result' => RaceResultResource::collection($this->resource['raceResult']),
            'Quali result' => QualiResultResource::collection($this->resource['qualiResult']),
            'Race Winner' => new RaceWinnerResource($this->resource['raceWinner']),
            'Pole Sitter' => new PoleManResource($this->resource['poleMan']),
            'Circuit' => new CircuitResource($this->resource['circuit']),
        ];
    }
}
