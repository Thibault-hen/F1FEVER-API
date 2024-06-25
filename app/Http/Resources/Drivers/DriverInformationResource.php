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
            'Name' => $this['driver']->forename . ' ' . $this['driver']->surname,
            'Number' => (string) $this['driver']->number ?? 'N/A',
            'Code' => $this['driver']->code ?? 'N/A',
            'Date of birth' => $this['driver']->dob,
            'Nationality' => $this['driver']->nationality,
            'Wikipedia link' => $this['driver']->url,
            'Wikipedia img' => $this['wikiImg']
        ];
    }
}
