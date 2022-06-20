<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'slug' => $this->faker->slug,
            'title' => $this->faker->word,
            'summary' => $this->faker->sentence,
            'body' => $this->faker->realText(),
            'published_at' => today()->toDateTimeString(),
            'featured_image' => $this->faker->imageUrl(),
            'featured_image_caption' => $this->faker->sentence,
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'meta' => [
                'title' => $this->faker->sentence,
                'description' => $this->faker->sentence,
                'canonical_link' => $this->faker->sentence,
            ],
        ];
    }
}
