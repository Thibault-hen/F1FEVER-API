<?php

namespace App\Http\Resources\Constructors;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ConstructorActiveSeasonsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'total' => (string) $this['total'],
            'seasons_list' => $this['year']
        ];
    }
}
