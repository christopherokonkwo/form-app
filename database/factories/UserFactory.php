<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\IncidentReport>
 */
class UserFactory extends Factory
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
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'username' => Str::slug($this->faker->unique()->userName),
            'password' => bcrypt($this->faker->password),
            'summary' => $this->faker->sentence,
            'avatar' => gravatar($this->faker->email),
            'dark_mode' => $this->faker->numberBetween(0, 1),
            'digest' => $this->faker->numberBetween(0, 1),
            'locale' => $this->faker->locale,
            'role' => $this->faker->numberBetween(1, 3),
        ];
    }
}
