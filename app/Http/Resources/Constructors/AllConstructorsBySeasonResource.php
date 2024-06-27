<?php

namespace App\Http\Resources\Constructors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class AllConstructorsBySeasonResource extends JsonResource
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
            'nationality' => $this->nationality,
            'wikipedia_link' => $this->url,
            'slug' => Str::slug($this->constructorRef)
        ];
    }
}
