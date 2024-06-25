<?php

namespace App\Services;

use App\Exceptions\InvalidSeasonException;
use App\Models\Seasons;
use Illuminate\Support\Facades\Validator;

class SeasonService
{
    public function getMinMaxSeasons(): array
    {
        return [
            "min_season" => $this->getMinSeason(),
            "max_season" => $this->getMaxSeason(),
        ];
    }

    private function getMinSeason(): int
    {
        return Seasons::min("year");
    }

    private function getMaxSeason(): int
    {
        return Seasons::max("year");
    }

    public function validateSeasonRange($season): mixed
    {
        $seasonsRange = $this->getMinMaxSeasons();

        $messages = [
            "season" => "The season must be an integer",
            "between" => "The season must be between {$seasonsRange["min_season"]} and {$seasonsRange["max_season"]}"
        ];

        $rules = [
            "season" => "required|integer|between:{$seasonsRange["min_season"]},{$seasonsRange["max_season"]}"
        ];

        $validator = Validator::make(["season" => $season], $rules, $messages)->stopOnFirstFailure();

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw new InvalidSeasonException($errors);
        }

        // Season is valid
        return null;
    }
}
