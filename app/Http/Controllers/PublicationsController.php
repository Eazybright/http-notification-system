<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\ReturnsJsonResponses;
use App\Services\PublicationService;

class PublicationsController extends Controller
{
  use ReturnsJsonResponses;
  
  protected $publicationService;

  public function __construct(PublicationService $publicationService)
  {
    $this->publicationService = $publicationService;
  }

  /**
   * Publish Message to a topic
   * @param string topic
   */
  public function publish(Request $request, $topic)
  {
    if(empty($request->all())){
      return $this->errorResponse('Request body must contain a valid param', 'publish failed', 400);
    }

    $publish = $this->publicationService->publishMessage($topic, $request->all());
    if(isset($publish['publish_status']) && !$publish['publish_status']){
      return $this->errorResponse('Topic not published', 500);
    }

    return $this->successResponse([
      'topic' => $topic,
      'data' => $request->all()
    ]);
  }

  /**
   * Send Message to all Subscribers
   */
  public function getMesaage(Request $request)
  {
    $host = $_SERVER['HTTP_HOST'];
    $message = $this->publicationService->getMessage($host);

    if(isset($message) && !$message['topic']){
      return $this->errorResponse('No meesage found', 400);
    }

    return $this->successResponse($message);
  }
}
