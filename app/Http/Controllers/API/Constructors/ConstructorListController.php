<?php

namespace App\Http\Controllers\API\Constructors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Constructors\ConstructorListRepository;
use App\Services\SeasonService;
use Illuminate\Http\JsonResponse;

class ConstructorListController extends Controller
{
    protected $seasonService;
    private $constructorListRepository;
    public function __construct(ConstructorListRepository $constructorsListRepository, SeasonService $seasonService)
    {
        $this->constructorListRepository = $constructorsListRepository;
        $this->seasonService = $seasonService;
    }
    public function getAllConstructors(): JsonResponse
    {
        return response()->json(["data" => $this->constructorListRepository->getAllConstructors()], 200);
    }

    public function getAllConstructorsBySeason(Request $request): JsonResponse
    {

        $season = $request->route("season");

        $this->seasonService->validateSeasonRange($season);

        return response()->json(["data" => $this->constructorListRepository->getAllConstructorsBySeason($season)], 200);
    }
}
