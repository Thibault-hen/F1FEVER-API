<?php

namespace App\Services;

use App\Exceptions\InvalidCircuitException;
use Illuminate\Support\Facades\Validator;

class CircuitService{
    /**
     * Validate the provided circuit reference
     * 
     * @param string $name
     * @return mixed return null if validation passes
     * @throws InvalidCircuitException if validation fails
     */
    public function validateCircuitName($name): mixed
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'regex:/^[\pL_-]+$/u',
                'exists:circuits,circuitRef'
            ],
        ];

        $messages = [
            'name.required' => 'The circuit name is required',
            'name.string' => 'The circuit name must be a valid string',
            'name.regex' => 'The cirucit name can only contain letters',
            'name.exists' => 'Cannot found this circuit',
        ];

        $validator = Validator::make(['name' => $name], $rules, $messages)->stopOnFirstFailure();

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw new InvalidCircuitException($errors);
        }

        return null;
    }
}