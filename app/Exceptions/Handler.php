<?php

namespace App\Exceptions;

use App\Traits\ApiResponseTrait;
use Illuminate\Database\QueryException;
use Illuminate\Database\UniqueConstrainedViolationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Validation\ValidationException;
use Illuminate\Routing\Exceptions\MethodNotAllowedHttpException;
use Illuminate\Support\Str;

class Handler extends ExceptionHandler
{
     use ApiResponseTrait;
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
    }

     public function render($request, $e): Response
    {
        if ($request->expectsJson() || Str::contains($request->path(), 'api')) {
        Log::error($e);

        if ($e instanceof AuthenticationException) {
            return $this->apiResponse([
                'message' => 'Unauthorized or expired token, try to login again',
                'success' => false,
                'exception' => $e,
                'error_code' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }

        if ($e instanceof NotFoundHttpException) {
            return $this->apiResponse([
                'message' => 'Route Not Found',
                'success' => false,
                'exception' => $e,
                'error_code' => $e->getStatusCode(),
            ], $e->getStatusCode());
        }

        if ($e instanceof ValidationException) {
            return $this->apiResponse([
                'message' => 'Validation Failed',
                'success' => false,
                'exception' => $e,
                'error_code' => Response::HTTP_UNPROCESSABLE_ENTITY,
                'errors' => $e->errors(),
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

         if ($e instanceof AccountNumberExistException) {
            return $this->apiResponse([
                'message' => $e->getMessage(),
                'success' => false,
                'exception' => $e,
                'error_code' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

    if ($e instanceof InvalidAccountNumberException) {
            return $this->apiResponse([
                'message' => $e->getMessage(),
                'success' => false,
                'exception' => $e,
                'error_code' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->apiResponse([
                'message' => 'Resource could not be found',
                'success' => false,
                'exception' => $e,
                'error_code' => Response::HTTP_NOT_FOUND,
            ], Response::HTTP_NOT_FOUND);
        }

        if ($e instanceof UniqueConstraintViolationException) {
            return $this->apiResponse([
                'message' => 'Duplicate entry found',
                'success' => false,
                'exception' => $e,
                'error_code' => Response::HTTP_CONFLICT,
            ], Response::HTTP_CONFLICT);
        }

        if ($e instanceof QueryException) {
            return $this->apiResponse([
                'message' => 'Could not execute query',
                'success' => false,
                'exception' => $e,
                'error_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        if ($e instanceof MethodNotAllowedHttpException) {
            return $this->apiResponse([
                'message' => 'HTTP Method not allowed',
                'success' => false,
                'exception' => $e,
                'error_code' => Response::HTTP_METHOD_NOT_ALLOWED,
            ], Response::HTTP_METHOD_NOT_ALLOWED);
        }

        // Custom pin exceptions
        if (
            $e instanceof PinNotSetException ||
            $e instanceof InvalidPinLengthException ||
            $e instanceof PinHasAlreadyBeenSetException
        ) {
            return $this->apiResponse([
                'message' => $e->getMessage(),
                'success' => false,
                'exception' => $e,
                'error_code' => Response::HTTP_BAD_REQUEST,
            ], Response::HTTP_BAD_REQUEST);
        }

        if ($e instanceof \Error || $e instanceof \Exception) {
            return $this->apiResponse([
                'message' => 'We could not handle your request',
                'success' => false,
                'exception' => $e,
                'error_code' => Response::HTTP_INTERNAL_SERVER_ERROR,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

       return parent::render($request, $e);
    }
}
