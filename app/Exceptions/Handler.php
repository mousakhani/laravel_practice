<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
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
        })->stop();

        $this->renderable(function (Exception $exception, Request $request) {
            if ($request->is('users/*'))
                return response()->json(['message' => 'User not found'], 404);
            if ($request->is('buyers/*'))
                return response()->json(['message' => 'Buyer not found'], 404);
            if ($request->is('sellers/*'))
                return response()->json(['message' => 'Seller not found'], 404);
        });
    }
}
