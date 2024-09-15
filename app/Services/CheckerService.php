<?php

namespace App\Services;

use App\Models\Races;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator;

class CheckerService
{
    public function validateGrandPrix(int $season, string $name): JsonResponse
    {
        $doesGrandPrixExist = Races::where("name", $name)
            ->where("year", $season)
            ->exists();

        if (!$doesGrandPrixExist) {
            return response()->json([
                'success' => 'false',
                'message' => 'this grand prix do not exist for the given season',
            ], 404);
        }
        // Grand Prix is valid
        return response()->json([
            'success' => 'true',
            'message' => 'validation passed',
        ], 200);
    }

    public function validateSeason($season): JsonResponse
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
            return response()->json([
                'success' => 'false',
                'message' => $errors,
            ], 404);
        }

        // Season is valid
        return response()->json([
            'success' => 'true',
            'message' => 'validation passed',
        ], 200);
    }

    public function validateDriver($name): JsonResponse
    {
        $rules = [
            "name" => [
                "required",
                "string",
                "exists:drivers,driverRef"
            ],
        ];

        $messages = [
            "name.required" => "The driver name is required.",
            "name.string" => "The driver name must be a valid string.",
            "name.exists" => "Cannot found this driver.",
        ];

        $validator = Validator::make(["name" => $name], $rules, $messages)->stopOnFirstFailure();

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            return response()->json([
                'success' => 'false',
                'message' => $errors,
            ], 404);
        }

        // driver name is valid
        return response()->json([
            'success' => 'true',
            'message' => 'validation passed',
        ], 200);
    }

    public function validateConstructor($name): JsonResponse
    {
        $rules = [
            "name" => [
                "required",
                "string",
                "exists:constructors,constructorRef"
            ],
        ];

        $messages = [
            "name.required" => "The constructor name is required.",
            "name.string" => "The constructor name must be a valid string.",
            "name.exists" => "Cannot found this constructor.",
        ];

        $validator = Validator::make(["name" => $name], $rules, $messages)->stopOnFirstFailure();

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            return response()->json([
                'success' => 'false',
                'message' => $errors,
            ], 404);
        }

        // constructor name is valid
        return response()->json([
            'success' => 'true',
            'message' => 'validation passed',
        ], 200);
    }
}