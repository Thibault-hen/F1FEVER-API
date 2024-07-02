<?php

namespace App\Http\Resources\LapTimes;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->forename . ' ' . $this->surname,
            'nationality' => $this->nationality
        ];
    }
}
