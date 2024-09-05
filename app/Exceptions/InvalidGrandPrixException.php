<?php

namespace App\Exceptions;

use Exception;

class InvalidGrandPrixException extends Exception
{
    public function __construct($message = "Invalid Grand Prix name provided")
    {
        parent::__construct($message);
    }

    public function render($request)
    {
        return response()->json([
            'error' => 'Invalid Grand Prix Name',
            'message' => $this->getMessage()
        ], 404);
    }
}
