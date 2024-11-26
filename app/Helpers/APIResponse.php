<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class APIResponse
{
    public static function make(bool $success, string $type, string $message, $data = []): JsonResponse
    {
        $response = [
            'success' => $success,
            'type' => $type,
            'message' => $message
        ];

        if (!empty($data)) {
            $response['data'] = $data;
        }

        return response()->json($response);
    }
}
