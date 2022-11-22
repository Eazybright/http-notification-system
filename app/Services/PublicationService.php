<?php

namespace App\Services;

use App\Models\Message;
use App\Models\Publication;
use Illuminate\Support\Facades\DB;

class PublicationService
{
  protected $subscriptionService;

  public function __construct(SubscriptionService $subscriptionService)
  {
    $this->subscriptionService = $subscriptionService;
  }
  
  public function publishMessage(string $topic, array $payloadData)
  {
    DB::beginTransaction();

    try{
      $publication = new Publication;
      $publication->body = json_encode($payloadData);
      $publication->topic = $topic;
      $publication->save();
  
      $subscriptionExist = $this->subscriptionService->subscriptionExist($topic);
  
      if($subscriptionExist){
        $subscribers = $this->subscriptionService->getSubscribersByTopic($topic);
        if($subscribers && count($subscribers)){
          foreach($subscribers as $subscriber){
            $message = new Message;
            $message->publication_id = $publication->id;
            $message->subscriber_id = $subscriber->id;
            $message->save();
          }
        }
      }

      Publication::whereId($publication->id)->update(['published' => true]);
      DB::commit();

      return true;
    }catch(\Exception $e){
      DB::rollback();
      throw $e;
      return [
        'publish_status' => false
      ];
    }
    
  }

  public function getMessage(string $host)
  {
    $subscriber = $this->subscriptionService->getSubscriberByHost($host);

    if(!count($subscriber)){
      return false;
    } 

    $message = Message::whereIn('subscriber_id', $subscriber)
    ->where('seen', false)
    ->with('publication')->first();

    if(!$message){
      return false;
    }

    return [
      'topic' => $message->publication->topic,
      'data' => json_decode($message->publication->body),
    ];
  }
}