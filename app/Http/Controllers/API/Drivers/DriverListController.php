<?php

namespace App\Http\Controllers\API\Drivers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Drivers\DriverListRepository;
use App\Services\SeasonService;
use Illuminate\Http\JsonResponse;

class DriverListController extends Controller
{
    protected $seasonService;
    private $driverListRepository;
    public function __construct(DriverListRepository $driversListRepository, SeasonService $seasonService)
    {
        $this->driverListRepository = $driversListRepository;
        $this->seasonService = $seasonService;
    }
    public function getAllDrivers(): JsonResponse
    {
        return response()->json(['data' => $this->driverListRepository->getAllDrivers()], 200);
    }

    public function getAllDriversBySeason(Request $request): JsonResponse
    {
        $season = $request->route('season');

        $this->seasonService->validateSeasonRange($season);

        return response()->json(['data' => $this->driverListRepository->getAllDriversBySeason($season)], 200);
    }
}
