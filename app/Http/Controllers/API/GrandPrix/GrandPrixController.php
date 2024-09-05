<?php

namespace App\Http\Controllers\API\GrandPrix;

use App\Http\Resources\GrandPrix\GrandPrixResource;
use App\Http\Resources\GrandPrixPreview\GrandPrixPreviewResource;
use App\Http\Controllers\Controller;
use App\Repositories\GrandPrix\GrandPrixRepository;
use App\Repositories\RaceSchedule\RaceScheduleRepository;
use App\Services\GrandPrixService;
use App\Services\SeasonService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GrandPrixController extends Controller
{
    protected int $currentYear;

    public function __construct(
        protected GrandPrixService $gpService,
        protected SeasonService $seasonService,
        protected GrandprixRepository $grandprixRepository,
        protected RaceScheduleRepository $raceScheduleRepository
    ) {
        $this->currentYear = Carbon::now()->year;
    }

    public function getGrandPrix(Request $request): JsonResponse
    {
        $season = $request->route('season');
        $name = $request->route('name');


        if ($request->is('api/grand-prix/latest')) {
            $season = $this->currentYear;
            $name = $this->raceScheduleRepository->getLastGpName();
        }

        $this->seasonService->validateSeasonRange($season);
        $this->gpService->validateGpName($name);

        $grandPrixResults = $this->grandprixRepository->getGrandPrixData($this->gpService->getGpName(), $season);

        return response()->json(['data' => $grandPrixResults], 200);
    }

    public function getGrandPrixPreview(): JsonResponse
    {
        $gpName = $this->raceScheduleRepository->getLastGpName();
        //Fetch grand prix data
        $grandPrixResults = $this->grandprixRepository->getGrandPrixPreviewData($gpName, $this->currentYear);

        //Return the grand prix data
        return response()->json(['data' => $grandPrixResults], 200);
    }
}
