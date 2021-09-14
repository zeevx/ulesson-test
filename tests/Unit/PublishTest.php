<?php

use App\Models\Subscription;
use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('can not publish to subscription with topic that do not exist', function (){
    $title = 'random';
    $data = [
        'message' => 'Hello'
    ];
    $response = $this->postJson("/api/publish/$title", $data);
    $response->assertStatus(422);
});


it('can not publish to subscription that do not have subscribers', function (){
    $topic = Topic::factory()->create();
    $title = $topic->title;
    $data = [
        'message' => 'Hello'
    ];
    $response = $this->postJson("/api/publish/$title", $data);
    $response->assertStatus(422);
});


it('can publish to subscription', function (){
    $subscription = Subscription::factory()->create();
    $title = $subscription->topic->title;
    $data = [
        'message' => 'Hello'
    ];
    $response = $this->postJson("/api/publish/$title", $data);
    $response->assertStatus(200);
});
