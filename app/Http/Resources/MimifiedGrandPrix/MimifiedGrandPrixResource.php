<?php

namespace App\Http\Resources\MimifiedGrandPrix;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\MimifiedGrandPrix\RaceResultResource;
use App\Http\Resources\MimifiedGrandPrix\CircuitResource;
class MimifiedGrandPrixResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "Race result" => RaceResultResource::collection($this->resource["raceResult"]),
            "Circuit" => new CircuitResource($this->resource["circuit"])
        ];
    }
}
