<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ApiController extends Controller
{
    /**
     * Return a successful response with data.
     *
     * @param mixed $data
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponseWithData($data = [], $statusCode = 200): JsonResponse
    {
        return response()->json([
            'data' => $data
        ], $statusCode);
    }

    /**
     * Return a successful response without data.
     *
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse($statusCode = 200): JsonResponse
    {
        return response()->json([
            'message' => 'Success'
        ], $statusCode);
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
}
