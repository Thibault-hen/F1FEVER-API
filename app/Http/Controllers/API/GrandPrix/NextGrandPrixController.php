<?php

namespace App\Http\Controllers\API\GrandPrix;

use App\Http\Controllers\Controller;
use App\Repositories\RaceSchedule\RaceScheduleRepository;
use Illuminate\Http\JsonResponse;

class NextGrandPrixController extends Controller
{
    public function __construct(
        protected RaceScheduleRepository $raceScheduleRepository
    ) {
    }
    public function getNextGrandPrix(): JsonResponse
    {
        $nextRound = $this->raceScheduleRepository->getNextRound();

        if (!$nextRound) {
            return response()->json(['error' => 'No next round data found'], 404);
        }

        return response()->json(['data' => $nextRound], 200);
    }
}
