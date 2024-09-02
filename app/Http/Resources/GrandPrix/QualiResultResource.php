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
            'name' => $this['forename'] . ' ' . $this['surname'],
            'nationality' => $this['nationality'],
            'team' => $this['team'],
            'q1_time' => !empty($this['q1']) ? $this['q1'] : null,
            'q2_time' => !empty($this['q2']) ? $this['q2'] : null,
            'q3_time' => !empty($this['q3']) ? $this['q3'] : null,
            'position' => (string) $this['position']
        ];
    }
}
