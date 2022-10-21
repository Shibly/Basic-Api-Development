<?php

namespace App\Traits;


use Illuminate\Http\JsonResponse;

trait HttpResponses
{


    /**
     * @param $data
     * @param $message
     * @param int $code
     * @return JsonResponse
     */
    protected function success($data, $message = null, int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'Request was successful',
            'message' => $message,
            'data' => $data
        ], $code);
    }


    /**
     * @param $data
     * @param $message
     * @param $code
     * @return JsonResponse
     */
    protected function error($data, $message = null, $code): JsonResponse
    {
        return response()->json([
            'status' => 'Error has occurred...',
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
