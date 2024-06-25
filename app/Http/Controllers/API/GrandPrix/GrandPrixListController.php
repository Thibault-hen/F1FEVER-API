<?php

namespace App\Http\Controllers\API\GrandPrix;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\GrandPrix\GrandPrixListRepository;
use App\Services\GrandPrixService;
use App\Services\SeasonService;
use Illuminate\Http\JsonResponse;

class GrandPrixListController extends Controller
{
    private $grandPrixListRepository;
    private $seasonService;
    private $grandPrixService;
    public function __construct(GrandPrixListRepository $grandPrixListRepository, SeasonService $seasonService, GrandPrixService $grandPrixService)
    {
        $this->grandPrixListRepository = $grandPrixListRepository;
        $this->seasonService = $seasonService;
        $this->grandPrixService = $grandPrixService;
    }
    public function getCurrentSeasonRounds(): JsonResponse
    {
        $grandPrixList = $this->grandPrixListRepository->getCurrentSeasonRounds();

        if ($grandPrixList->isEmpty()) {
            return response()->json(["error" => "No data found for current season rounds"], 404);
        }

        return response()->json(["Data" => $grandPrixList], 200);
    }

    public function getRoundsBySeason(Request $request) : JsonResponse
    {
        $season = $request->route("season");

        $this->seasonService->validateSeasonRange($season);

        $grandPrixList = $this->grandPrixListRepository->getRoundsBySeason($season);

        return response()->json(["Data" => $grandPrixList], 200);
    }

    public function getRoundsByName(Request $request) : JsonResponse
    {
        $name = $request->route("name");

        $this->grandPrixService->validateGpName($name);
        
        $grandPrixList = $this->grandPrixListRepository->getRoundsByName($this->grandPrixService->getGpName());

        return response()->json(["Data" => $grandPrixList], 200);
    }
}
