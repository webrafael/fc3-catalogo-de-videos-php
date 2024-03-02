<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Response;
use CatalogVideo\Domain\Exceptions\NotFoundException;
use CatalogVideo\Domain\Notification\NotificationException;
use CatalogVideo\Domain\Exceptions\EntityValidationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

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
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundException) {
            return $this->showError($exception->getMessage(), Response::HTTP_NOT_FOUND);
        }

        if ($exception instanceof EntityValidationException) {
            return $this->showError($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($exception instanceof NotificationException) {
            return $this->showError($exception->getMessage(), Response::HTTP_UNPROCESSABLE_ENTITY);
        } // ok => HTTP_INTERNAL_SERVER_ERROR

        return parent::render($request, $exception);
    }

    private function showError(string $message, int $statusCode)
    {
        return response()->json([
            'message' => $message,
        ], $statusCode);
    }
}
