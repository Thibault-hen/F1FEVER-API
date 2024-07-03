<?php

namespace App\Http\Controllers\API\Constructors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Constructors\ConstructorListRepository;
use App\Services\SeasonService;
use Illuminate\Http\JsonResponse;

class ConstructorListController extends Controller
{
    public function __construct(
        protected ConstructorListRepository $constructorsListRepository,
        protected SeasonService $seasonService
    ) {
    }
    public function getAllConstructors(): JsonResponse
    {
        return response()->json(['data' => $this->constructorsListRepository->getAllConstructors()], 200);
    }

    public function getAllConstructorsBySeason(Request $request): JsonResponse
    {

        $season = $request->route('season');

        $this->seasonService->validateSeasonRange($season);

        return response()->json(['data' => $this->constructorsListRepository->getAllConstructorsBySeason($season)], 200);
    }
}
