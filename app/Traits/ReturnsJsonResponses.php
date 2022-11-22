<?php

namespace App\Traits;

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

  public function validationErrorResponse($message, $error, $http_status, array $headers= [])
  {
    $data = [
      'message' => $message,
      'error' => $error,
      'status' => false
    ];
    return response()->json($data, $http_status);
  }
}
