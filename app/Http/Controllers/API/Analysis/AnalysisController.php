<?php

namespace App\Http\Controllers\API\Analysis;

use App\Http\Controllers\API\RaceReport\RaceReportController;
use App\Http\Controllers\Controller;
use App\Repositories\Analysis\AnalysisRepository;
use App\Services\GrandPrixService;
use App\Services\RaceReportService;
use Illuminate\Http\Request;

class AnalysisController extends Controller
{
    public function __construct(
        protected AnalysisRepository $analysisRepository,
        protected GrandPrixService $grandPrixService,
        protected RaceReportService $raceReportService
    ) {
    }
    public function getSeasons(Request $request)
    {
        $seasonResult = $this->analysisRepository->getSeasonsList();

        return response()->json(['data' => $seasonResult], 200);
    }
    public function getGrandPrix(Request $request)
    {
        $season = $request->route('season');

        $this->raceReportService->isLapTimesAvailable($season);

        $grandPrixResult = $this->analysisRepository->getGrandPrixList($season);

        return response()->json(['data' => $grandPrixResult], 200);
    }
    public function getDrivers(Request $request)
    {
        $season = $request->route('season');
        $gpName = $request->route('grandprix');

        $this->raceReportService->isLapTimesAvailable($season);
        $this->grandPrixService->validateGpName($gpName);

        $driversResult = $this->analysisRepository->getDriversList($season, $this->grandPrixService->getGpName());

        return response()->json(['data' => $driversResult], 200);
    }
}
