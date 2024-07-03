<?php

namespace App\Http\Controllers\API\Drivers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Drivers\DriverListRepository;
use App\Services\SeasonService;
use Illuminate\Http\JsonResponse;

class DriverListController extends Controller
{
    public function __construct(
        protected DriverListRepository $driversListRepository,
        protected SeasonService $seasonService
    ) {
    }
    public function getAllDrivers(): JsonResponse
    {
        return response()->json(['data' => $this->driversListRepository->getAllDrivers()], 200);
    }

    public function getAllDriversBySeason(Request $request): JsonResponse
    {
        $season = $request->route('season');

        $this->seasonService->validateSeasonRange($season);

        return response()->json(['data' => $this->driversListRepository->getAllDriversBySeason($season)], 200);
    }
}
