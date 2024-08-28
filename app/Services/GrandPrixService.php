<?php

namespace App\Services;

use App\Exceptions\InvalidGrandPrixException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class GrandPrixService
{
    protected string $gpName = "";

    /**
     * Format the provided Grand Prix name by replacing dashes with spaces and capitalizing each word.
     * 
     * @param string $gpName
     * @return void
     */
    private function formatGpName($gpName): void
    {
        $formattedGpName = Str::of($gpName)
            ->replace("-", " ")
            ->title()
            ->__toString();

        $this->gpName = $formattedGpName;
    }

    /**
     * Validate the provided grand prix name
     * 
     * @param string $gpName
     * @return mixed return null if validation passes
     * @throws InvalidGrandPrixException if validation fails
     */
    public function validateGpName($gpName): mixed
    {
        $this->formatGpName($gpName);

        // Validation rules
        $rules = [
            "name" => [
                "required",
                "string",
                "regex:/^[\pL\pN\s]+$/u",
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

    /**
     * Retrieve the formatted grand prix name
     * 
     * @return string
     */
    public function getGpName(): string
    {
        return $this->gpName;
    }
}
