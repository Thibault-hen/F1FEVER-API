<?php

namespace App\Http\Resources\GrandPrix;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class PoleManResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {

        return [
            'name' => $this['forename'] . ' ' . $this['surname'] ?? null,
            'nationality' => $this['nationality'] ?? null,
            'team' => $this['team'] ?? null,
            'time' => $this['q3'] ?? $this['q1'] ?? null,
        ];
    }
}
