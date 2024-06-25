<?php

namespace App\Exceptions;

use Exception;

class InvalidDriverException extends Exception
{
    public function __construct($message = "Invalid driver name provided")
    {
        parent::__construct($message);
    }
    
    public function render($request)
    {
        return response()->json([
            'error' => 'Invalid Driver Name',
            'message' => $this->getMessage()
        ], 422);
    }
}
