<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    /**
     * Return a successful response.
     *
     * @param string $message
     * @param int $statusCode
     * @param mixed $data
     * @return JsonResponse
     */
    protected function successResponse($message, $statusCode = 200, $data = []): JsonResponse
    {
        $responseData = [
            'message' => $message
        ];

        if (! empty($data)) {
            $responseData['data'] = $data;
        }

        return response()->json($responseData, $statusCode);
    }

    /**
     * Return a successful response with data.
     *
     * @param string $message
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponseWithData($message, $data, $statusCode = 200): JsonResponse
    {
        return $this->successResponse($message, $statusCode, $data);
    }

    /**
     * Return an error response with errors.
     *
     * @param string $message
     * @param array $errors
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponseWithErrors($message, array $errors = [], $statusCode = 400): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'errors' => $errors
        ], $statusCode);
    }

    /**
     * Return an error response without errors.
     *
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function errorResponse($message, $statusCode = 400): JsonResponse
    {
        return response()->json([
            'message' => $message
        ], $statusCode);
    }

    public function handleException(Exception $e)
    {
        /**
         * Developer's Note:
         *
         * While it's preferable to send error messages to Rollbar, Sentry,
         * or a similar error tracking application rather than logging them locally,
         * for the sake of this code challenge, local logging is being used.
         */
        Log::error($e);

        if ($e instanceof ModelNotFoundException) {
            return $this->errorResponse('Resource requested not found', Response::HTTP_NOT_FOUND);
        }

        return $this->errorResponse('Something went wrong', Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
