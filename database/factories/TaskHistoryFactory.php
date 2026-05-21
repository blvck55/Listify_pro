<?php

namespace Database\Factories;

use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskHistoryFactory extends Factory
{
    protected $model = TaskHistory::class;

    public function definition(): array
    {
        $action = fake()->randomElement(['created', 'updated', 'completed', 'deleted']);

        $oldStatus = in_array($action, ['updated', 'completed'])
            ? fake()->randomElement(['pending', 'completed'])
            : null;

        $newStatus = match ($action) {
            'created'   => 'pending',
            'completed' => 'completed',
            'updated'   => fake()->randomElement(['pending', 'completed']),
            'deleted'   => null,
        };

        return [
            'task_id'    => Task::factory(),
            'user_id'    => User::factory(),
            'action'     => $action,
            'old_status' => $oldStatus,
            'new_status' => $newStatus,
            'changed_at' => fake()->dateTimeBetween('-30 days', 'now'),
        ];
    }

    public function created(): static
    {
        return $this->state([
            'action'     => 'created',
            'old_status' => null,
            'new_status' => 'pending',
        ]);
    }

    public function completed(): static
    {
        return $this->state([
            'action'     => 'completed',
            'old_status' => 'pending',
            'new_status' => 'completed',
        ]);
    }
}
