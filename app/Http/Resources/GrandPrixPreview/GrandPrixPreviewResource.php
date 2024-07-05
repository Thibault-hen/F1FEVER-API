<?php

namespace App\Http\Resources\GrandPrixPreview;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\GrandPrixPreview\RaceResultResource;
use App\Http\Resources\GrandPrixPreview\CircuitResource;
class GrandPrixPreviewResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'grand_prix_info' => new RaceNameResource($this->resource['raceName']),
            'race_result' => RaceResultResource::collection($this->resource['raceResult']),
            'circuit' => new CircuitResource($this->resource['circuit'])
        ];
    }
}
