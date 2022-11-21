<?php

namespace App\Services;

use App\Models\Publication;
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

  public function publishMessage(string $topic, array $payloadData)
  {
    $publication = new Publication;
    $publication->body = json_encode($payloadData);
    $publication->topic = $topic;
    $publication->save();
    $publish_status = Redis::publish($topic, json_encode($payloadData));
    return [
      'publication_id' => $publication->id,
      'publish_status' => $publish_status
    ];
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