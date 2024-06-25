<?php

namespace App\Http\Controllers\API\Circuits;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Circuits\CircuitsListRepository;
use App\Services\SeasonService;
use Illuminate\Http\JsonResponse;

class CircuitListController extends Controller
{
    protected $seasonService;
    private $circuitsListRepository;
    public function __construct(CircuitsListRepository $circuitListRepository, SeasonService $seasonService)
    {
        $this->circuitsListRepository = $circuitListRepository;
        $this->seasonService = $seasonService;
    }
    public function getAllCircuits(): JsonResponse
    {
        return response()->json(["data" => $this->circuitsListRepository->getAllCircuits()], 200);
    }

    public function getAllCircuitsBySeason(Request $request): JsonResponse
    {
        $season = $request->route("season");

        $this->seasonService->validateSeasonRange($season);

        return response()->json(["Data" => $this->circuitsListRepository->getAllCircuitsBySeason($season)], 200);
    }
}
