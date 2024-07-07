<?php

namespace App\Services;

use App\Exceptions\InvalidSeasonException;
use Illuminate\Support\Facades\Validator;

class SeasonService
{
    /**
     * Validate the provided season
     * 
     * @param int $season
     * @return mixed return null if validation passes
     * @throws InvalidSeasonException if validation fails
     */
    public function validateSeasonRange($season): mixed
    {
        $rules = [
            "season" => [
                "required",
                "integer",
                "exists:seasons,year"
            ],
        ];

        $messages = [
            "season.required" => "The season is required.",
            "season.integer" => "The season must be a valid integer.",
            "season.exists" => "Cannot found this season.",
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
