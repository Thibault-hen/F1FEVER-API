<?php

namespace App\Repositories\Seasons;

use App\Http\Resources\Season\SeasonResource;
use App\Models\Seasons;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SeasonRepository
{
    /**
     * Retrieve all available seasons, ordered in descending order
     * 
     * @return ResourceCollection
     */
    public function getSeasons(): ResourceCollection
    {
        return SeasonResource::collection(Seasons::orderByDesc('year')->get());
    }
}