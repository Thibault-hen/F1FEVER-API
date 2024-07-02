<?php

namespace App\Http\Resources\RaceReport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaceReportLaptimesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'lap' => (string) $this->lap,
            'position' => (string) $this->position,
            'time' => $this->time,
            'milliseconds' => (string) $this->milliseconds
        ];
    }
}
