<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        // API Routes not found exception
        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'Not found',
                    'message' => $e->getMessage(),
                ], 404);
            }
        });

        // // General exception handler
        // $this->renderable(function (\Exception $e, $request) {
        //     if ($request->is('api/*')) {
        //         return response()->json([
        //             'error' => 'Server Error',
        //             'message' => $e->getMessage(),
        //         ], 500);
        //     }
        // });
    }
}
