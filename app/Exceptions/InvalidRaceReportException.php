<?php

namespace App\Exceptions;

use Exception;

class InvalidRaceReportException extends Exception
{
    public function __construct($message = "Invalid race name/season/driver provided")
    {
        parent::__construct($message);
    }
    
    public function render($request)
    {
        return response()->json([
            'error' => 'Cannot found the race report',
            'message' => $this->getMessage()
        ], 404);
    }
}
