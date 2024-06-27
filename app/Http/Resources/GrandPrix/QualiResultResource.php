<?php

namespace App\Http\Resources\GrandPrix;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QualiResultResource extends JsonResource
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
            'q1_time' => $this->q1 ?? 'N/A',
            'q2_time' => $this->q2 ?? 'N/A',
            'q3_time' => $this->q3 ?? 'N/A',
            'position' => (string) $this->position
        ];
    }
}
