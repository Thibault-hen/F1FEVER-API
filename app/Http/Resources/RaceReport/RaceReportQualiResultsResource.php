<?php

namespace App\Http\Resources\RaceReport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaceReportQualiResultsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'position' => (string) $this->position, 
            'q1_time' => $this->q1,
            'q2_time' => $this->q2,
            'q3_time' => $this->q3
        ];
    }
}
