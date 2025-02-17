<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Host>
 */
class HostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->company(),
            'ip' => fake()->ipv4(),
            'location' => fake()->country(),
            'type' => fake()->randomElement(['Slow', 'Medium','Fast']),
            'provider_id' => fake()->randomElement(['1', '2','3']),
            'created_at' => now(),
            'updated_at' => now(),
            
        ];
    }
}
