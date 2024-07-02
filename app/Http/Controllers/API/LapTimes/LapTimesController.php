<?php

namespace App\Http\Controllers\API\LapTimes;

use App\Http\Controllers\Controller;
use App\Repositories\LapTimes\LapTimesRepository;
use App\Services\DriverService;
use App\Services\GrandPrixService;
use App\Services\RaceReportService;
use App\Services\SeasonService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LapTimesController extends Controller
{
    public function __construct(
        protected LapTimesRepository $lapTimesRepository,
        protected RaceReportService $raceReportService,
        protected GrandPrixService $grandPrixService,
        protected DriverService $driverService
    ) {
    }
    public function getLapTimes(Request $request) : JsonResponse
    {
        $season = $request->route('season');
        $gpName = $request->route('grandprix');
        $driver = $request->route('driver');

        $this->raceReportService->isLapTimesAvailable($season);
        $this->grandPrixService->validateGpName($gpName);
        $this->driverService->validateDriverName($driver);

        $lapTimesResults = $this->lapTimesRepository->getLapTimes($season, $this->grandPrixService->getGpName(), $driver);

        return response()->json(['data' => $lapTimesResults], 200);
    }
}
