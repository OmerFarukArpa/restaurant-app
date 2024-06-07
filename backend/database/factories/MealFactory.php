<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => random_int(1,10),
            'name' => fake()->name,
            'image' => fake()->image('public/storage/meals', 640, 480, null, false),
            'description' => fake()->paragraph,
            'price' => fake()->randomFloat(2,1,99)
        ];
    }
}
