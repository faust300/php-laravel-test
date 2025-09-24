<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($data = null, string $message = "OK", int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public static function error(
        string $message = "Error",
        int $code = 1000,
        $errors = null,
        int $status = 400
    ) {
        return response()->json([
            'success' => false,
            'message' => $message,
            'code'    => $code,
            'errors'  => $errors,
        ], $status);
    }
}