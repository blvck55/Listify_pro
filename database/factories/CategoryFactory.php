<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'name'    => fake()->randomElement([
                'Work', 'Personal', 'Study', 'Health',
                'Finance', 'Shopping', 'Travel', 'Home',
            ]),
            'colour'  => fake()->randomElement([
                '#3B82F6', '#22C55E', '#F59E0B', '#EF4444',
                '#8B5CF6', '#EC4899', '#14B8A6', '#F97316',
            ]),
        ];
    }
}
