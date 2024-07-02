<?php

namespace App\Http\Controllers\API\RaceReport;

use App\Http\Controllers\Controller;
use App\Repositories\RaceReport\RaceReportRepository;
use App\Services\DriverService;
use App\Services\GrandPrixService;
use App\Services\RaceReportService;
use App\Services\SeasonService;
use Illuminate\Http\Request;

class RaceReportController extends Controller
{
    public function __construct(
        protected RaceReportRepository $raceReportRepository,
        protected SeasonService $seasonService,
        protected GrandPrixService $grandPrixService,
        protected DriverService $driverService,
        protected RaceReportService $raceReportService
    ) {
    }
    public function getRaceReport(Request $request)
    {
        $season = $request->route('season');
        $gpName = $request->route('grandprix');
        $driver = $request->route('driver');

        $this->raceReportService->isLapTimesAvailable($season);
        $this->grandPrixService->validateGpName($gpName);
        $this->driverService->validateDriverName($driver);

        return $this->raceReportRepository->getRaceReport($season, $this->grandPrixService->getGpName(), $driver);
    }
}
