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
            'team' => $this['constructor']->name,
            'nationality' => $this['constructor']->nationality,
            'wikipedia_link' => $this['constructor']->url,
            'wikipedia_img' => $this['wikiImg']
        ];
    }
}
