<?php

namespace App\Http\Resources\Drivers;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DriverInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this['driver']->forename . ' ' . $this['driver']->surname,
            'number' => (string) $this['driver']->number ?? 'N/A',
            'code' => $this['driver']->code ?? 'N/A',
            'date_of_birth' => $this['driver']->dob,
            'nationality' => $this['driver']->nationality,
            'wikipedia_link' => $this['driver']->url,
            'wikipedia_img' => $this['wikiImg']
        ];
    }
}
