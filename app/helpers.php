<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

if (! function_exists('success_response')) {
    function success_response(array|JsonResource $data = null, string $message = '', int $httpStatus = Response::HTTP_OK)
    {
        $response = [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];

        return new JsonResponse(
            data: $response,
            status: $httpStatus,
            options: JSON_PRESERVE_ZERO_FRACTION
        );
    }
}

if (! function_exists('error_response')) {
    function error_response(string $message = '', int $httpStatus = Response::HTTP_NOT_FOUND, array $errors = null)
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (! empty($errors)) {
            $response['errors'] = $errors;
        }

        return new JsonResponse($response, $httpStatus);
    }
}
