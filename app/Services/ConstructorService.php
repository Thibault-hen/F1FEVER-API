<?php

namespace App\Services;

use App\Exceptions\InvalidConstructorException;
use Illuminate\Support\Facades\Validator;

class ConstructorService
{
    /**
     * Validate the provided constructor reference
     * 
     * @param string $name
     * @return mixed return null if validation passes
     * @throws InvalidConstructorException if validation fails
     */
    public function validateConstructorName($name): mixed
    {
        $rules = [
            'name' => [
                'required',
                'string',
                "regex:/^[\pL\pN\s]+$/u",
                'exists:constructors,constructorRef'
            ],
        ];

        $messages = [
            'name.required' => 'The constructor name is required',
            'name.string' => 'The constructor name must be a valid string',
            'name.regex' => 'The constructor name can only contain letters',
            'name.exists' => 'Cannot found this constructor',
        ];

        $validator = Validator::make(['name' => $name], $rules, $messages)->stopOnFirstFailure();

        if ($validator->fails()) {
            $errors = $validator->errors()->first();
            throw new InvalidConstructorException($errors);
        }

        return null;
    }
}
