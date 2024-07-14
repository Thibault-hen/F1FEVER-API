<?php

namespace App\Repositories\Constructors;

use App\Models\Constructors;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Constructors\AllConstructorsResource;
use App\Http\Resources\Constructors\AllConstructorsBySeasonResource;

class ConstructorListRepository
{
    /**
     * Retrieve all constructor information
     * 
     * @return ResourceCollection
     */
    public function getAllConstructors(): ResourceCollection
    {
        return AllConstructorsResource::collection(Constructors::all());
    }

    /**
     * Retrieve all constructor information with the given season
     * 
     * @param int $season
     * @return ResourceCollection
     */
    public function getAllConstructorsBySeason(int $season): ResourceCollection
    {
        return AllConstructorsBySeasonResource::collection(
            Constructors::select("constructors.*")
                ->distinct()
                ->join("constructorstandings", "constructors.constructorId", "constructorstandings.constructorId")
                ->join("races", "constructorstandings.raceId", "races.raceId")
                ->where("races.year", $season)
                ->get()
        );

    }
}
