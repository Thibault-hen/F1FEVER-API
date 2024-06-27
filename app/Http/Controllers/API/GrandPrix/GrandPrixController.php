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

    protected $seasonService;
    protected $gpService;
    private $grandprixRepository;
    private $raceScheduleRepository;
    protected int $currentYear;

    public function __construct(GrandPrixService $gpService, SeasonService $seasonService, GrandprixRepository $grandprixRepository, RaceScheduleRepository $raceScheduleRepository)
    {
        $this->seasonService = $seasonService;
        $this->gpService = $gpService;
        $this->grandprixRepository = $grandprixRepository;
        $this->raceScheduleRepository = $raceScheduleRepository;
        $this->currentYear = Carbon::now()->year;
    }
    public function getGrandPrix(Request $request): JsonResponse
    {
        //Perform season and grand prix name validation
        $season = $request->route('season');
        $name = $request->route('name');

        //Get latest grand prix name if the request is for the lastest grand prix
        if ($request->is('api/grand-prix/latest')) {
            $season = $this->currentYear;
            $name = $this->raceScheduleRepository->getLastGpName();
        }

        //Perform gp name and season validation
        $this->seasonService->validateSeasonRange($season);
        $this->gpService->validateGpName($name);

        //Fetch grand prix data
        $grandPrixResults = $this->grandprixRepository->getGrandPrixData($this->gpService->getGpName(), $season);

        //Return the grand prix data
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
