<?php

namespace App\Exceptions;

use Exception;

class InvalidSeasonException extends Exception
{
    public function __construct($message = "Invalid season provided")
    {
        parent::__construct($message);
    }
    
    public function render($request)
    {
        return response()->json([
            'error' => 'Invalid Season',
            'message' => $this->getMessage()
        ], 422);
    }
}
