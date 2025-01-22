<?php

namespace App\Traits;

trait ApiResponseTrait
{
    protected function successResponse($data = [], $message = 'Request successful', $status = 200)
    {
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    protected function errorResponse($message = 'Something went wrong', $errors = [], $status = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
