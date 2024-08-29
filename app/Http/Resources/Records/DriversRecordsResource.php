<?php

namespace App\Http\Resources\Records;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriversRecordsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'wins_record' => [
                'name' => $this->resource['total_wins']['name'],
                'nationality' => $this->resource['total_wins']['nationality'],
                'total' => (string) $this->resource['total_wins']['wins']
            ],
            'podiums_record' => [
                'name' => $this->resource['total_podiums']['name'],
                'nationality' => $this->resource['total_podiums']['nationality'],
                'total' => (string) $this->resource['total_podiums']['podiums']
            ],
            'poles_record' => [
                'name' => $this->resource['total_poles']['name'],
                'nationality' => $this->resource['total_poles']['nationality'],
                'total' => (string) $this->resource['total_poles']['poles']
            ],
            'laps_record' => [
                'name' => $this->resource['total_laps']['name'],
                'nationality' => $this->resource['total_laps']['nationality'],
                'total' => (string) $this->resource['total_laps']['laps']
            ],
            'points_record' => [
                'name' => $this->resource['total_points']['name'],
                'nationality' => $this->resource['total_points']['nationality'],
                'total' => (string) $this->resource['total_points']['points']
            ],
            'sprint_record' => [
                'name' => $this->resource['total_sprints']['name'],
                'nationality' => $this->resource['total_sprints']['nationality'],
                'total' => (string) $this->resource['total_sprints']['sprints']
            ]
        ];
    }
}
