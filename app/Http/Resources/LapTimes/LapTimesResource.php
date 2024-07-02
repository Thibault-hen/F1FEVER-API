<?php

namespace App\Http\Resources\LapTimes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LapTimesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'driver' => DriverInfoResource::collection($this->resource['driverInfo']),
            'lap_times' => LapTimesInfoResource::collection($this->resource['lapTimes'])
        ];
    }
}
