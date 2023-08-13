<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
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
            if ($exception instanceof ValidationException) {
                return response()->json(
                    ['error' => $exception->errors(),],
                    400
                );
            }
            if ($exception instanceof HttpException) {

                return response()->json(
                    ['error' => $exception->getMessage(), 'code' => $exception->getStatusCode()],
                    $exception->getStatusCode()
                );
            }
        });
    }
}
