<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\JsonResponse;
class Handler extends ExceptionHandler
{

    protected $dontReport = [
        //
    ];


    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
    // public function render($request, Throwable $exception): JsonResponse
    // {
    //     if ($exception instanceof ValidationException) {
    //         return response()->json([
    //             'message' => 'Validation failed',
    //             'errors' => $exception->errors()
    //         ], 422);
    //     }
    
    //     return parent::render($request, $exception);
    // }
    public function render($request, Throwable $exception)
{
    if ($exception instanceof ValidationException) {
        return response()->json([
            'message' => 'Validation failed',
            'errors' => $exception->errors()
        ], 422);
    }

    // Handle ModelNotFoundException (e.g., no user found with the given ID)
    if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
        return response()->json([
            'message' => 'Resource not found'
        ], 404);
    }

    // Default response for other exceptions
    return parent::render($request, $exception);
}
}


// namespace App\Exceptions;

// use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
// use Throwable;
// use Illuminate\Validation\ValidationException;
// use Illuminate\Http\JsonResponse;
// use Symfony\Component\HttpFoundation\Response;

// class Handler extends ExceptionHandler
// {
//     /**
//      * A list of the exception types that are not reported.
//      *
//      * @var array<int, class-string<Throwable>>
//      */
//     protected $dontReport = [
//         //
//     ];

//     /**
//      * A list of the inputs that are never flashed for validation exceptions.
//      *
//      * @var array<int, string>
//      */
//     protected $dontFlash = [
//         'current_password',
//         'password',
//         'password_confirmation',
//     ];

//     /**
//      * Register the exception handling callbacks for the application.
//      *
//      * @return void
//      */
//     public function register()
//     {
//         $this->reportable(function (Throwable $e) {
//             //
//         });
//     }

//     /**
//      * Render the exception into an HTTP response.
//      *
//      * @param  \Illuminate\Http\Request  $request
//      * @param  \Throwable  $exception
//      * @return \Illuminate\Http\JsonResponse
//      */
//     public function render($request, Throwable $exception): JsonResponse
//     {
//         // Handle ValidationException
//         if ($exception instanceof ValidationException) {
//             return response()->json([
//                 'message' => 'Validation failed',
//                 'errors' => $exception->errors()
//             ], 422);
//         }

//         // If it's a ModelNotFoundException (e.g., no user found with the given ID)
//         if ($exception instanceof \Illuminate\Database\Eloquent\ModelNotFoundException) {
//             return response()->json([
//                 'message' => 'Resource not found'
//             ], 404);
//         }

//         // Default response for other exceptions
//         return parent::render($request, $exception);
//     }
// }
