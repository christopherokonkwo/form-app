<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\View>
 */
class ViewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'post_id' => $this->faker->uuid,
            'ip' => $this->faker->ipv4,
            'agent' => $this->faker->userAgent,
            'referer' => $this->faker->url,
        ];
    }
}
