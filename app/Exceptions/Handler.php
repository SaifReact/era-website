<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (ValidationException $e, $request) {
            if ($request->ajax() && $request->acceptsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation failed.',
                    'data' => null,
                    'errors' => $e->errors(),
                ], 422);
            }
        });

        $this->renderable(function (LogicalExceptionable $e, $request) {
            //$request->acceptsJson();
            if ($request->acceptsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => "Logical error. {$e->getMessage()}",
                    'data' => null,
                    'errors' => ['model' => [
                        $e->getMessage()
                    ]
                    ],
                ], 422);
            }
        });

        $this->renderable(function (AuthenticationException $e, $request) {
            if ($request->ajax() && $request->acceptsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Valid auth credentials required.',
                    'data' => null,
                    'errors' => $e->getMessage(),
                ], 401);
            }

            return redirect()->guest('login');
        });

        $this->renderable(function (NotFoundHttpException $e, $request) {
            if ($request->ajax() && $request->acceptsJson()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Not found.',
                    'data' => null,
                    'errors' => null,
                ], 404);
            }
        });
    }
}
