<?php

namespace App\Services;

use App\Exceptions\InvalidRaceReportException;
use App\Models\Races;
use App\Repositories\Analysis\AnalysisRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RaceReportService
{
    public function __construct()
    {
    }

    /**
     * Retrieve the seaons where detailed lap times and race report are available
     * 
     * @return Collection
     */
    public function getSeasonsList(): Collection
    {
        return Races::whereHas('laptimes')
            ->distinct()
            ->orderBy('year', 'asc')
            ->pluck('year');
    }

    /**
     * Validate the provided season to check if detailed lap times and race report are available.
     * 
     * @param int $season
     * @return mixed return null if validation passes
     * @throws InvalidRaceReportException if validation fails
     */
    public function isLapTimesAvailable($season): mixed
    {
        $rules = [
            "season" => [
                "required",
                "integer",
                Rule::in($this->getSeasonsList())
            ],
        ];

        // Custom error messages
        $messages = [
            "season.required" => "The season is required.",
            "season.integer" => "The season must be a valid integer.",
            "season.in" => "Cannot found this season.",
        ];

        $validator = Validator::make(["season" => $season], $rules, $messages)->stopOnFirstFailure();

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw new InvalidRaceReportException($errors);
        }
        // Season is valid
        return null;
    }
}