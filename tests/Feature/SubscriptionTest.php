<?php

namespace Tests\Feature;

use App\Models\Subscription;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
  use RefreshDatabase;
  
  /**
   * Subscription is created.
   *
   * @return void
   */
  public function testSubcriptionCreated()
  {
    $body = [
      'url' => 'http://mysubscriber.test'
    ];

    $response = $this->post('api/subscribe/topic1', $body, ['Accept' => 'application/json']);

    $response->assertStatus(200);
    $response->assertJsonStructure(['url', 'topic']);
    $result = Subscription::whereTopic('topic1')->get();
    $this->assertCount(1, $result);
  }

  public function testUrlParamIsRequired()
  {
    $response = $this->post('api/subscribe/topic1', [], ['Accept' => 'application/json']);

    $response->assertStatus(422);
    $response->assertJsonStructure(['message', 'error', 'status']);
  }
}
