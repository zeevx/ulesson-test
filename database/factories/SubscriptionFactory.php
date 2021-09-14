<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $topic = Topic::factory()->create();
        return [
            'topic_id' => $topic->id,
            'url' => 'http://example.com'
        ];
    }
}
