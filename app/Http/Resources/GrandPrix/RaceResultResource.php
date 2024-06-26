<?php

namespace App\Http\Resources\GrandPrix;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaceResultResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Name' => $this->fullname,
            'Nationality' => $this->nationality,
            'Team' => $this->constructors,
            'Time' => $this->time ?? 'N/A',
            'Status' => stripos($this->status, 'laps') !== false || stripos($this->status, 'lap') !== false || $this->status === 'Finished' ? $this->status : 'DNF',
            'Laps completed' => (string) $this->laps,
            'Starting position' => (string) $this->grid,
            'Final Position' => (string) $this->positionOrder
        ];
    }
}
