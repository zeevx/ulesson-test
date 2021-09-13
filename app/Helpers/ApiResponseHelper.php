<?php
namespace App\Helpers;

use Illuminate\Http\JsonResponse;

class ApiResponseHelper {

    /**
     * @param $code
     * @param $message
     * @param $data
     * @return JsonResponse
     */
    public static function successResponse($code, $message, $data): JsonResponse
    {
        return response()->json([
            'success'=> true,
            'message' => $message,
            'data' => $data
        ], $code);
    }

    /**
     * @param $code
     * @param $message
     * @param $data
     * @return JsonResponse
     */
    public static function errorResponse($code, $message, $data): JsonResponse
    {
        return response()->json([
            'success'=> false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
