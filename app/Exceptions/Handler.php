<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Arr;
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

    /**
 * Convert a validation exception into a JSON response.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  \Illuminate\Validation\ValidationException  $exception
 * @return \Illuminate\Http\JsonResponse
 */

//  protected function invalidJson($request, ValidationException $exception)
// {
//     $jsonResponse = parent::invalidJson($request, $exception);

//     $original = (array) $jsonResponse->getData();

//     $jsonResponse->setData(array_merge($original, [
//         'status'    => $exception->status,
//         'errors'        => self::expandDotNotationKeys((array) $original['errors']),
//     ]));

//     return $jsonResponse;
// }

// private static function expandDotNotationKeys(Array $array)
// {
//     $result = [];

//     foreach ($array as $key => $value) {
//      Arr::set($result, $key, $value);
//     }

//     return $result;
// }
}
