<?php

use App\Models\Topic;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(Tests\TestCase::class, RefreshDatabase::class);

it('does not create a topic without a title field', function () {
    $response = $this->postJson('/api/topic/create', []);
    $response->assertStatus(422);
});


it('can not fetch topics because they do not exist', function () {
    $response = $this->getJson('/api/topic');
    $response->assertStatus(422)->assertJson(['message' => 'No topics yet']);
});

it('can create a topic', function () {
    $attributes = Topic::factory()->raw();
    $response = $this->postJson('/api/topic/create', $attributes);
    $response->assertStatus(200)->assertJson(['message' => 'Topic created successfully']);
    $this->assertDatabaseHas('topics', $attributes);
});

it('can fetch topics', function () {
    $topic = Topic::factory()->create();
    $response = $this->getJson("/api/topic/");
    $data = [
        'success' => true,
        'message' => 'Topics fetched successfully',
        'data' => array([
            'id' => $topic->id,
            'title' => $topic->title
        ])
    ];
    $response->assertStatus(200)->assertJson($data);
});

it('can delete a topic', function () {
    $topic = Topic::factory()->create();
    $response = $this->deleteJson("/api/topic/delete/{$topic->id}");
    $response->assertStatus(200)->assertJson(['message' => 'Topic deleted successfully']);
});

it('can not delete a topic that does not exist', function () {
    $response = $this->deleteJson("/api/topic/delete/20");
    $response->assertStatus(422)->assertJson(['message' => 'Topic not found']);
});
