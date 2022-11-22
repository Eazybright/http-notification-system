<?php

namespace App\Http\Controllers;

use App\Traits\ReturnsJsonResponses;
use App\Http\Requests\SubscribeRequest;
use App\Services\SubscriptionService;
use App\Services\PublicationService;
use Superbalist\PubSub\Adapters\LocalPubSubAdapter;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionsController extends Controller
{
  use ReturnsJsonResponses;
  
  protected $subscriptionService;

  public function __construct(SubscriptionService $subscriptionService)
  {
    $this->subscriptionService = $subscriptionService;
  }

  /**
   * Subscribe to a topic
   * @param string topic
   */
  public function subscribe(SubscribeRequest $request, string $topic)
  {
    $topic = strip_tags($topic); //remove unneccessary characters.
    $url = $request->url;

    $data = [
      'host' => $_SERVER['HTTP_HOST'],
      'url' => $url,
      'topic' => $topic
    ];
    $subscribe = $this->subscriptionService->createSubscription($data);
    
    if(!$subscribe){
      // subsciption not created
      return $this->errorResponse('Subscription not created');
    }

    return $this->successResponse(['url' => $request->url, 'topic' => $topic]);
  }
}
