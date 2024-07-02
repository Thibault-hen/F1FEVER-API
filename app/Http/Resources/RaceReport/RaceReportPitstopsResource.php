<?php

namespace App\Http\Resources\RaceReport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaceReportPitstopsResource extends JsonResource
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
            'time' => $this->time,
            'duration' => $this->duration,
            'milliseconds' => (string) $this->milliseconds
        ];
    }
}
