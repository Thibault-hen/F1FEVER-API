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
            'grand_prix_name' => new RaceNameResource($this->resource['raceName']),
            'race_result' => RaceResultResource::collection($this->resource['raceResult']),
            'quali_result' => $this->resource['qualiResult']->isEmpty() ? null : QualiResultResource::collection($this->resource['qualiResult']),
            'race_winner' => new RaceWinnerResource($this->resource['raceWinner']),
            'pole_sitter' => new PoleManResource($this->resource['poleMan']),
            'circuit' => new CircuitResource($this->resource['circuit']),
        ];
    }
}
