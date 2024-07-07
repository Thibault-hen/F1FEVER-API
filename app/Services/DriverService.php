<?php

namespace App\Services;

use App\Exceptions\InvalidDriverException;
use Illuminate\Support\Facades\Validator;

class DriverService
{
    /**
     * Validate the provided driver reference
     * 
     * @param string $name
     * @return mixed return null if validation passes
     * @throws InvalidDriverException if validation fails
     */
    public function validateDriverName($name): mixed
    {
        $rules = [
            'name' => [
                'required',
                'string',
                'regex:/^[\pL_-]+$/u',
                'exists:drivers,driverRef'
            ],
        ];

        $messages = [
            'name.required' => 'The driver name is required',
            'name.string' => 'The driver name must be a valid string',
            'name.regex' => 'The driver name can only contain letters',
            'name.exists' => 'Cannot found this driver',
        ];

        $validator = Validator::make(['name' => $name], $rules, $messages)->stopOnFirstFailure();

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw new InvalidDriverException($errors);
        }

        return null;
    }
}
