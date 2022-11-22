<?php

namespace App\Services;

use App\Models\Subscription;
use Illuminate\Support\Facades\Redis;

class SubscriptionService
{
  public function createSubscription(array $data)
  {
    $subscription = new Subscription;
    $subscription->url = $data['url'];
    $subscription->topic = $data['topic'];
    $subscription->host = $data['host'];

    return $subscription->save();
  }

  public function subscriptionExist(string $topic)
  {
    return Subscription::whereTopic($topic)->exists();
  }

  public function getSubscribersByTopic(string $topic)
  {
    return Subscription::whereTopic($topic)->select('id')->get();
  }

  public function getSubscriberByHost(string $host)
  {
    return Subscription::whereHost($host)->select('id')->get();
  }
}