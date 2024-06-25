<?php

namespace App\Services;

use App\Exceptions\InvalidGrandPrixException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GrandPrixService
{
    protected string $gpName = "";
    private function formatGpName($gpName) : void
    {
        // Format the Grand Prix name (replace hyphens with spaces and title case)
        $formattedGpName = Str::of($gpName)
            ->replace("-", " ")
            ->title()
            ->__toString();

        $this->gpName = $formattedGpName;
    }
    public function validateGpName($gpName) : mixed
    {
        $this->formatGpName($gpName);

        // Validation rules
        $rules = [
            "name" => [
                "required",
                "string",
                "regex:/^[\pL\s]+$/u",
                "exists:races,name"
            ],
        ];

        // Custom error messages
        $messages = [
            "name.required" => "The grand prix name is required.",
            "name.string" => "The grand prix name must be a valid string.",
            "name.regex" => "The grand prix name can only contain letters and spaces.",
            "name.exists" => "Cannot found this grand prix.",
        ];

        // Create a validator instance
        $validator = Validator::make(["name" => $this->gpName], $rules, $messages)->stopOnFirstFailure();

        // Perform validation
        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw new InvalidGrandPrixException($errors);
        }

        return null;
    }

    public function getGpName() : string
    {
        return $this->gpName;
    }
}
