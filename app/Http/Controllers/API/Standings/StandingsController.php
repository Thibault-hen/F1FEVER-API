<?php

namespace App\Http\Controllers\API\Standings;

use App\Http\Controllers\Controller;
use App\Services\SeasonService;
use App\Repositories\Standings\StandingsRepository;
use Illuminate\Http\JsonResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StandingsController extends Controller
{
    public function __construct(
        protected SeasonService $seasonService,
        protected StandingsRepository $standingsRepository
    ) {
    }

    private function getStandings($season, $type): JsonResponse
    {
        $season = $season ?? Carbon::now()->year;

        $this->seasonService->validateSeasonRange($season);

        $standings = $this->standingsRepository->$type($season);

        return response()->json(['data' => $standings], 200);
    }

    public function driverStandings(Request $request): JsonResponse
    {
        return $this->getStandings($request->route('season'), 'drivers');
    }

    public function constructorStandings(Request $request): JsonResponse
    {
        return $this->getStandings($request->route('season'), 'constructors');
    }
}
