<?php

namespace App\Http\Controllers;

class BaseController extends Controller
{
    /**
     * success response method.
     * @param mixed $result - Result of data. Can be object, array, collection
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResponse(mixed $result, string $message): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }

    
    /**
     * return error response.
     * @param string $error - Error message
     * @param mixed $errorMessages - option error messages. A few error messages
     * @param int $code - optional error code, default is 500
     * @return \Illuminate\Http\JsonResponse
     */

    public function sendError(string $error, mixed $errorMessages = [], int $code = 500): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];
        if (!empty($errorMessages)) {
            $response['data'] = (is_null($errorMessages))?"Server Error!":$errorMessages;
        }

        return response()->json($response, $code);
    }

    /**
     * return unauthorized response.
     * @param string $error - Error message
     * @param mixed $errorMessages - option error messages. A few error messages
     * @param int $code - optional error code, default is 401
     * @return \Illuminate\Http\JsonResponse
     */

    public function sendUnauthorized(string $error, mixed $errorMessages = [], int $code = 401): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = 'Unauthorized';
        }

        return response()->json($response, $code);
    }

    /**
     * return bad request response.
     * @param string $error - Error message
     * @param mixed $errorMessages - option error messages. A few error messages
     * @param int $code - optional error code, default is 422
     * @return \Illuminate\Http\JsonResponse
     */

    public function sendBadRequest(string $error, mixed $errorMessages = [], int $code = 422): \Illuminate\Http\JsonResponse
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }

        return response()->json($response, $code);
    }
}
