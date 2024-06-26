<?php

namespace App\Http\Resources\Constructors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConstructorInformationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Team' => $this['constructor']->name,
            'Nationality' => $this['constructor']->nationality,
            'Wikipedia link' => $this['constructor']->url,
            'Wikipedia img' => $this['wikiImg']
        ];
    }
}
