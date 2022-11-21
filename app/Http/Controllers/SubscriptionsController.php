<?php

namespace App\Http\Controllers;

use App\Traits\ReturnsJsonResponses;
use App\Http\Requests\SubscribeRequest;
use App\Services\SubscriptionService;
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

  //
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

  public function publish(Request $request, $topic)
  {
    if(empty($request->all())){
      return $this->errorResponse('Request body must contain a valid param', 'publish failed', 400);
    }

    // $subscriptionExist = $this->subscriptionService->subscriptionExist($topic);

    // if(!$subscriptionExist){
    //   return $this->errorResponse('Subscription topic not found', 'publish failed', 400);
    // }

    $publish = $this->subscriptionService->publishMessage($topic, $request->all());
    if(isset($publish['publish_status']) && !$publish['publish_status']){
      return $this->errorResponse('Topic not published', 500);
    }

    return $this->successResponse([
      'topic' => $topic,
      'data' => $request->all()
    ]);

  }

  public function notifySubscribers($topic)
  {
    // dd("hello");
    // return "hello";
    return $this->subscriptionService->notifySubscribers($topic);
  }
}
