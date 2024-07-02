<?php

namespace App\Services;

use App\Exceptions\InvalidSeasonException;
use Illuminate\Support\Facades\Validator;

class SeasonService
{
    public function validateSeasonRange($season): mixed
    {
        // Validation rules
        $rules = [
            "season" => [
                "required",
                "integer",
                "exists:seasons,year"
            ],
        ];

        // Custom error messages
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
