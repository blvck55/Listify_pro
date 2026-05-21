<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'pending', 'completed']);

        return [
            'user_id'     => User::factory(),
            'category_id' => null,
            'title'       => fake()->sentence(fake()->numberBetween(3, 7)),
            'subtitle'    => fake()->boolean(60) ? fake()->sentence(4) : null,
            'description' => fake()->boolean(50) ? fake()->paragraph() : null,
            'due_date'    => fake()->boolean(70)
                ? fake()->dateTimeBetween('now', '+60 days')->format('Y-m-d')
                : null,
            'priority'    => fake()->randomElement(['low', 'medium', 'medium', 'high']),
            'status'      => $status,
        ];
    }

    public function pending(): static
    {
        return $this->state(['status' => 'pending']);
    }

    public function completed(): static
    {
        return $this->state(['status' => 'completed']);
    }

    public function highPriority(): static
    {
        return $this->state(['priority' => 'high']);
    }
}
