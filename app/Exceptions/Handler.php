<?php

namespace App\Exceptions;

use App\Models\Logs\LogError;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Arr;
use Throwable;
use Illuminate\Support\Facades\Log;

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
        Log::error("Error: " . $exception->getMessage());
        LogError::create([
            'message' => $exception->getMessage(),
            'request' => $request->getMethod() . ' ' . $request->getRequestUri(),
            //'params' => json_encode($request->getPayload()),
            'body' => $request->getContent(),
            'status' => $this->isHttpException($exception) ? $exception->getStatusCode() : $exception->getCode(),
        ]);

        if ($exception instanceof ExceptionCustom) { //ModelNotFoundException
            return $this->myConvertValidationExceptionToResponse($exception, $request);
        } else if ($this->isHttpException($exception)) {
            if ($exception->getStatusCode() == 404) {
                return response()->view('errors.404', [], 404);
            } else if ($exception->getStatusCode() == 500) {
                return response()->view('errors.500', [], 500);
            }
        }

        return parent::render($request, $exception);
    }

    protected function myConvertValidationExceptionToResponse(Throwable $e, $request)
    {

        if ($this->shouldReturnJson($request, $e) || request()->has('ajax')) {
            return response()->json([
                'success' => false,
                'title' => __('messages.error_title'),
                'error' => $e->getMessage(),
                'status' => $e->getCode(),
            ], $e->getCode());
        } else {
            return redirect(/*$e->redirectTo ?? */url()->previous())
                ->withInput(Arr::except($request->input(), $this->dontFlash))
                // ->withErrors($e->errors(), $request->input('_error_bag', $e->errorBag))
                ->with('title', __('messages.error_title'))
                ->with('error', $e->getMessage());
        }
    }
}
