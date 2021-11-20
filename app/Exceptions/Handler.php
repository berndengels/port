<?php
namespace App\Exceptions;

use Throwable;
//use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Bengels\LaravelEmailExceptions\Exceptions\EmailHandler as ExceptionHandler;

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
        $this->reportable(
            function (Throwable $e) {
                //
            }
        );
    }

    public function render($request, Throwable $e)
    {
        if ($request->wantsJson()) {
            $response = [
                'error' => $e->getMessage()
            ];
            $status = 400;

            if ($this->isHttpException($e)) {
                $status = $e->getStatusCode();
            }

            return response()->json($response, $status);
        }
        return parent::render($request, $e);
    }
}
