<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => 1,
            'company_name' => fake()->firstName,
            'info' => fake()->paragraph,
            'capacity' => 40,
            'image' => fake()->image('public/storage/settings', 640, 480, null, false),

        ];
    }
}
