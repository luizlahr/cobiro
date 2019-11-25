<?php

namespace App\Exceptions;

use Exception;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponser;

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        "password",
        "password_confirmation",
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        \Log::debug($exception);

        if ($exception instanceof NotFoundHttpException) {
            return $this->errorResponse(
                __("errors.route.notfound"),
                Response::HTTP_NOT_FOUND
            );
        }

        if ($exception instanceof HttpException) {
            $code = $exception->getStatusCode();
            $message = Response::$statusTexts[$code];

            return $this->errorResponse($message, $code);
        }

        if ($exception instanceof ModelNotFoundException) {
            $model = strtolower(class_basename($exception->getModel()));

            return $this->errorResponse(
                __("errors.model.notfound", ["model"=>$model]),
                Response::HTTP_NOT_FOUND
            );
        }

        if ($exception instanceof AuthorizationException) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_FORBIDDEN
            );
        }

        if ($exception instanceof AuthenticationException) {
            return $this->errorResponse(
                $exception->getMessage(),
                Response::HTTP_UNAUTHORIZED
            );
        }

        if ($exception instanceof ValidationException) {
            // if it is a test environment do not change the response format
            if (env("APP_ENV") === "testing") {
                return parent::render($request, $exception);
            }

            $errors = $exception->validator->errors()->getMessages();

            return $this->errorResponse(
                ["errors"=>$errors],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        if (env("APP_DEBUG", false)) {
            return parent::render($request, $exception);
        }

        $this->errorResponse(
            __("errors.unexpected"),
            Response::HTTP_INTERNAL_SERVER_ERROR5
        );
    }
}
