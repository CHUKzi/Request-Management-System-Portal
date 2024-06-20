<?php

namespace App\Utils;
use Illuminate\Support\Facades\Response;

class CoreUtil
{
    public function sendResponse($is_success, $result, $message, $errorMessage)
    {
        return Response::json([
            'success' => $is_success,
            'data' => $result,
            'message' => $message,
            'errorMessages' => $errorMessage,
        ]);
    }
}
