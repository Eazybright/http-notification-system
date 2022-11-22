<?php

namespace Tests\Feature;

use App\Models\Publication;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PublicationTest extends TestCase
{
  use RefreshDatabase;

  /**
   * Publish message to a topic.
   *
   * @return void
   */
  public function testPublishMessageToTopic()
  {
    $body = [
      "title" => "Manchester City Wins again with a stellar performance",
      "topic" => "sports",
      "body" => "Credibly enhance empowered benefits for enterprise-wide schemas. Compellingly foster cooperative ideas and focused communities. Rapidiously exploit e-business strategic theme areas via prospective web-readiness. Intrinsically streamline"
    ];
    $response = $this->post('/api/publish/topic1', $body, ['Accept' => 'application/json']);

    $response->assertStatus(200);
    $response->assertJsonStructure(['data', 'topic']);
    $result = Publication::whereTopic('topic1')->get();
    $this->assertCount(1, $result);
  }

  public function testBodyParamsMustNotBeEmpty()
  {
    $response = $this->post('/api/publish/topic1', [], ['Accept' => 'application/json']);

    $response->assertStatus(400);
    $response->assertJsonStructure(['message', 'error', 'status']);
  }

  public function testSubsciberGetMessage()
  {
    $this->post('api/subscribe/topic1', [
        'url' => 'http://mysubscriber.test'
      ], 
      ['Accept' => 'application/json']
    );

    $body = [
      "title" => "Manchester City Wins again with a stellar performance",
      "topic" => "sports",
      "body" => "Credibly enhance empowered benefits for enterprise-wide schemas. Compellingly foster cooperative ideas and focused communities. Rapidiously exploit e-business strategic theme areas via prospective web-readiness. Intrinsically streamline"
    ];
    $this->post('/api/publish/topic1', $body, ['Accept' => 'application/json']);

    $response = $this->post('/api/test1');

    $response->assertStatus(200);
    $response->assertJsonStructure(['data', 'topic']);
  }
}
