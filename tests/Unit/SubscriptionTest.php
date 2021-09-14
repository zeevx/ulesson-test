<?php

use App\Models\Subscription;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);


it('must contain a request with appropriate param(url)', function (){
    $topic = 'random';
    $data = [];
    $response = $this->postJson("/api/subscribe/$topic", $data);
    $response->assertStatus(422);
});


it('can not subscribe to topic that do not exist', function (){
    $topic = 'random';
    $response = $this->postJson("/api/subscribe/$topic", []);
    $response->assertStatus(422);
});

it('can subscribe to topic', function (){
    $topic = Topic::factory()->create();
    $title = $topic->title;
    $data = [
        'url' => 'https://test.com/'
    ];
    $response = $this->postJson("/api/subscribe/$title", $data);
    $response->assertStatus(200)->assertJson([
        'success' => true,
        'message' => "Subscription to $title successful",
        'data' => null
    ]);
});

it('cannot unsubscribe to topic without subscribers', function (){
    $topic = Topic::factory()->create();
    $title = $topic->title;
    $data = [];
    $response = $this->deleteJson("/api/unsubscribe/$title", $data);
    $response->assertStatus(422);
});


it('can unsubscribe to topic', function (){
    $subscription = Subscription::factory()->create();
    $title = $subscription->topic->title;
    $data = [];
    $response = $this->deleteJson("/api/unsubscribe/$title", $data);
    $response->assertStatus(200);
});
