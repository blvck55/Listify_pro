<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    protected $model = Notification::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['info', 'success', 'warning']);

        $messages = [
            'info'    => [
                'Your task is due tomorrow.',
                'You have 3 pending tasks.',
                'New tasks assigned to you.',
            ],
            'success' => [
                'Task completed successfully!',
                'All tasks for today are done.',
                'Great job! You completed 5 tasks this week.',
            ],
            'warning' => [
                'You have an overdue task.',
                'Task deadline has passed.',
                'Reminder: task due in 1 hour.',
            ],
        ];

        return [
            'user_id' => User::factory(),
            'message' => fake()->randomElement($messages[$type]),
            'type'    => $type,
            'is_read' => fake()->boolean(30),
        ];
    }

    public function unread(): static
    {
        return $this->state(['is_read' => false]);
    }

    public function read(): static
    {
        return $this->state(['is_read' => true]);
    }
}
