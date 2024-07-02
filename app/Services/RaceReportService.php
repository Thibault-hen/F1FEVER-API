<?php

namespace App\Services;

use App\Exceptions\InvalidRaceReportException;
use App\Models\Races;
use App\Repositories\Analysis\AnalysisRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class RaceReportService
{
    public function __construct()
    {
    }
    public function getSeasonsList()
    {
        return Races::whereHas('laptimes')
            ->distinct()
            ->orderBy('year', 'asc')
            ->pluck('year');
    }
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