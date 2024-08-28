<?php

namespace App\Http\Controllers\API\Checker;

use App\Http\Controllers\Controller;
use App\Models\Seasons;
use App\Services\CheckerService;
use App\Services\GrandPrixService;
use App\Services\SeasonService;
use Illuminate\Http\Request;

class CheckerController extends Controller
{
    public function __construct(
        protected CheckerService $checkerService,
        protected SeasonService $seasonService,
        protected GrandPrixService $grandPrixService
    ) {
    }
    public function checkSeason(Request $request)
    {
        $season = $request->route('season');

        return $this->checkerService->validateSeason($season);
    }

    public function checkGrandPrix(request $request)
    {
        $season = $request->route('season');
        $gpName = $request->route('name');

        $this->seasonService->validateSeasonRange($season);
        $this->grandPrixService->validateGpName($gpName);

        return $this->checkerService->validateGrandPrix($season, $this->grandPrixService->getGpName());
    }
}
