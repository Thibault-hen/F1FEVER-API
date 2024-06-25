<?php

namespace App\Repositories\Constructors;

use App\Models\Constructors;
use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Http\Resources\Constructors\AllConstructorsResource;
use App\Http\Resources\Constructors\AllConstructorsBySeasonResource;

class ConstructorListRepository
{
    public function getAllConstructors(): ResourceCollection
    {
        return AllConstructorsResource::collection(Constructors::all());
    }
    public function getAllConstructorsBySeason(int $season): ResourceCollection
    {
        $constructors = Constructors::select("constructors.*")
            ->distinct()
            ->join("constructorstandings", "constructors.constructorId", "constructorstandings.constructorId")
            ->join("races", "constructorstandings.raceId", "races.raceId")
            ->where("races.year", $season)
            ->get();

        return AllConstructorsBySeasonResource::collection($constructors);
    }
}
