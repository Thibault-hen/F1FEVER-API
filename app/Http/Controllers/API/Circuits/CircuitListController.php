<?php

namespace App\Http\Controllers\API\Circuits;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Circuits\CircuitListRepository;
use App\Services\SeasonService;
use Illuminate\Http\JsonResponse;

class CircuitListController extends Controller
{
    public function __construct(
        protected CircuitListRepository $circuitListRepository,
        protected SeasonService $seasonService
    ) {
    }
    public function getAllCircuits(): JsonResponse
    {
        return response()->json(['data' => $this->circuitListRepository->getAllCircuits()], 200);
    }

    public function getAllCircuitsBySeason(Request $request): JsonResponse
    {
        $season = $request->route('season');

        $this->seasonService->validateSeasonRange($season);

        return response()->json(['data' => $this->circuitListRepository->getAllCircuitsBySeason($season)], 200);
    }
}
