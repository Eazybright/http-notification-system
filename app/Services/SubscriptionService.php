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

  public function notifySubscribers(string $topic)
  {
    dd('servcie');
    echo 'start listening for published post on '. $topic .' topic' . PHP_EOL;

    return Redis::subscribe($topic, function ($payload) {
      echo 'message received!' . PHP_EOL;
      // $blog = json_decode($payload);
      // $users = [
      //     [
      //         "name" => "John Doe",
      //         "email" => "jon@gmail.com",
      //         "topics" => ['sports', 'food']
      //     ],
      //     [
      //         "name" => "Jane Doe",
      //         "email" => "jane@gmail.com",
      //         "topics" => ['sports', 'fashion']
      //     ]
      // ];
      // foreach ($users as $user) {
      //     foreach ($user['topics'] as $topic) {
      //         if ($blog->topic === $topic) {
      //             echo 'New blog on "' . $topic . '" for "' . $user['name'] . '" with title => "' . $blog->title . PHP_EOL;
      //         }
      //     }
      // }
      dd($payload);
  });
  }
}