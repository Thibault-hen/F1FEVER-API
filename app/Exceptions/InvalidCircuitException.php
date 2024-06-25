<?php

namespace App\Exceptions;

use Exception;

class InvalidCircuitException extends Exception
{
    public function __construct($message = "Invalid Circuit name provided")
    {
        parent::__construct($message);
    }
    
    public function render($request)
    {
        return response()->json([
            'error' => 'Invalid Circuit Name',
            'message' => $this->getMessage()
        ], 422);
    }
}
