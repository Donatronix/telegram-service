<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BaseController extends Controller
{
    /**
     * @param bool $error
     * @param int $responseCode
     * @param string $message
     * @param null $data
     * @return JsonResponse
     */
    public function responseJson($data = null, string $message = null, int $responseCode = 200, bool $error = false): JsonResponse
    {
        return response()->json([
            'error' => $error,
            'response_code' => $responseCode,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
