<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait ApiResponse
{
    public function successResponse($data, $message = null, $statusCode = Response::HTTP_OK)
    {
        return response()->json(['resource' => $data, 'message' => $message], $statusCode);
    }

    public function errorResponse($message, $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY, $extraData = null)
    {
        $data = is_array($message) ? ['errors' => $message] : ['error' => $message];
        if ($extraData) {
            $data["resource"] = $extraData;
        }
        return response()->json($data, $statusCode);
    }
}
