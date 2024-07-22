<?php

namespace App\Http\Resources\GrandPrixPreview;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class RaceNameResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'year' => (string) $this->year,
            'date' => $this->date,
            'time' => Carbon::createFromFormat('H:i:s', $this->time)->format('H:i'),
            'slug' => Str::slug($this->name)
        ];
    }
}
