<?php

namespace App\Exceptions;

use Exception;

class InvalidConstructorException extends Exception
{
    public function __construct($message = "Invalid Constructor name provided")
    {
        parent::__construct($message);
    }
    
    public function render($request)
    {
        return response()->json([
            'error' => 'Invalid Constructor Name',
            'message' => $this->getMessage()
        ], 422);
    }
}
