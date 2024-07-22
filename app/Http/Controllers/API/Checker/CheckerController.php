<?php

namespace App\Http\Controllers\API\Checker;

use App\Http\Controllers\Controller;
use App\Models\Seasons;
use App\Services\CheckerService;
use Illuminate\Http\Request;

class CheckerController extends Controller
{
    public function __construct(
        protected CheckerService $checkerService
    ) {
    }
    public function checkSeason(Request $request)
    {
        $season = $request->route('season');

        return $this->checkerService->validateSeason($season);
    }
}
