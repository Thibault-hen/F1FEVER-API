<?php

namespace App\Repositories\Seasons;

use App\Http\Resources\Season\SeasonResource;
use App\Models\Seasons;

class SeasonRepository{
    public function getSeasons()
    {
        return SeasonResource::collection(Seasons::orderByDesc('year')->get());
    }
}