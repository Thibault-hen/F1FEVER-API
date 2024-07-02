<?php

namespace App\Http\Resources\LapTimes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LapTimesInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
             'lap_number' => (string) $this->lap,
             'lap_position' => (string) $this->position,
             'lap_time' => $this->time
        ];
    }
}
