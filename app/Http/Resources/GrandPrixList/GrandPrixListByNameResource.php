<?php

namespace App\Http\Resources\GrandPrixList;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class GrandPrixListByNameResource extends JsonResource
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
            'location' => $this->location,
            'country' => $this->country,
            'time' => $this->time,
            'date' => $this->date,
            'podium' => [
                'winner' => $this->getPodiumPosition($this->podium, 1),
                'second' => $this->getPodiumPosition($this->podium, 2),
                'third' => $this->getPodiumPosition($this->podium, 3),
            ],
            'slug' => $this->formatUrlSlug($this->name),
            'season' => $this->formatUrlDate($this->date)
        ];
    }

    private function formatUrlSlug(string $slug) : string
    {
        return Str::slug($slug, '-');
    }

    private function formatUrlDate(string $date) : int
    {
        $carbonDate = Carbon::parse($date);
        return $carbonDate->year;
    }
    private function getPodiumPosition($podium, $position)
    {
        if (!$podium) {
            return null;
        }

        $positions = explode(', ', $podium);
        return isset($positions[$position - 1]) ? $positions[$position - 1] : null;
    }
}
