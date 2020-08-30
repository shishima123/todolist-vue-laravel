<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

class ApiController extends Controller
{
    public function successResponse($message) {
        return response()->json([
            'status' => 200,
            'message' => $message,
        ], 200);
    }

    public function errorResponse($message, $statusCode = 400, $statusType = 400) {
        return response()->json([
            'status' => $statusType,
            'message' => $message,
        ], $statusCode);
    }

    public function customResponse($jsonError = [], $statusCode = 200) {
        return response()->json($jsonError, $statusCode);
    }
}
