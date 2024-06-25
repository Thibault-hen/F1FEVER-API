<?php

namespace App\Http\Controllers\API\GrandPrix;

use App\Http\Controllers\Controller;
use App\Repositories\RaceSchedule\RaceScheduleRepository;
use Illuminate\Http\JsonResponse;

class NextGrandPrixController extends Controller
{
    private $raceScheduleRepository;
    public function __construct(RaceScheduleRepository $raceScheduleRepository)
    {
        $this->raceScheduleRepository = $raceScheduleRepository;
    }
    public function getNextGrandPrix(): JsonResponse
    {
        $nextRound = $this->raceScheduleRepository->getNextRound();

        if (!$nextRound) {
            return response()->json(["error" => "No next round data found"], 404);
        }

        return response()->json(["Data" => $nextRound], 200);
    }
}
