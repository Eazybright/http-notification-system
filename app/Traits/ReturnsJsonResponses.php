<?php

namespace App\Traits;

use Illuminate\Support\MessageBag;

trait ReturnsJsonResponses
{
  public function successResponse($data=[], $http_status=200)
  {
    return response()->json($data, $http_status); 
  }

  public function errorResponse($error="An error occurred", $message="Failed", $http_status=500)
  {
    $status = false;
    $error_data = compact('status', 'message', 'error');
    return response()->json($error_data, $http_status);
  }

  public function exception_response(\Exception $exception, $message="An error occurred")
  {
    $error_data = [
        "status" => false,
        "message" => $exception->getMessage(),
        "error" => $message
    ];
    return response()->json($error_data, 500);
  }

  public function validationErrorResponse($message, $error, $http_status, array $headers= [])
  {
    $data = [
      'message' => $message,
      'error' => $error,
      'status' => false
    ];
    return response()->json($data, $http_status);
  }

  protected function withArray(array $array, int $http_status = 200, array $headers = [], $options = 0)
  {
    return response()->json($array, $http_status, $headers, $options);
  }
}
