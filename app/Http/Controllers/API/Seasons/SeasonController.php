<?php

namespace App\Http\Controllers\API\Seasons;

use App\Http\Controllers\Controller;
use App\Repositories\Seasons\SeasonRepository;
use Illuminate\Http\Request;

class SeasonController extends Controller
{
    public function __construct(
        protected SeasonRepository $seasonRepository
    ) {
    }
    public function getSeasons()
    {
        $seasonsResult = $this->seasonRepository->getSeasons();

        return response()->json(['data' => $seasonsResult], 200);
    }
}
