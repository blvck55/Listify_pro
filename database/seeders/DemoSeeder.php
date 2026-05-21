<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Notification;
use App\Models\Task;
use App\Models\TaskHistory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        TaskHistory::truncate();
        Notification::truncate();
        Task::truncate();
        Category::truncate();
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
        // Admin user (fixed credentials for demo)
        User::factory()->create([
            'name'     => 'Admin User',
            'email'    => 'admin@listify.com',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);

        // Regular test user (fixed credentials for demo)
        $testUser = User::factory()->create([
            'name'     => 'Test User',
            'email'    => 'test@listify.com',
            'password' => Hash::make('password'),
            'role'     => 'user',
        ]);

        // 8 extra random users
        $randomUsers = User::factory(8)->create();

        // Categories for test user
        $categories = collect(['Work', 'Personal', 'Study'])->map(fn ($name, $i) =>
            Category::factory()->create([
                'user_id' => $testUser->id,
                'name'    => $name,
                'colour'  => ['#3B82F6', '#22C55E', '#F59E0B'][$i],
            ])
        );

        // 5 tasks for test user across categories
        $tasks = collect([
            ['title' => 'Complete SSP2 assignment', 'priority' => 'high',   'status' => 'pending',   'category_id' => $categories[0]->id],
            ['title' => 'Review project proposal',  'priority' => 'medium', 'status' => 'pending',   'category_id' => $categories[0]->id],
            ['title' => 'Go to the gym',             'priority' => 'low',    'status' => 'completed', 'category_id' => $categories[1]->id],
            ['title' => 'Study Laravel Sanctum',     'priority' => 'high',   'status' => 'pending',   'category_id' => $categories[2]->id],
            ['title' => 'Buy groceries',             'priority' => 'low',    'status' => 'completed', 'category_id' => $categories[1]->id],
        ])->map(fn ($data) =>
            Task::factory()->create(array_merge($data, ['user_id' => $testUser->id]))
        );

        // Task history for the test tasks
        TaskHistory::factory()->created()->create([
            'task_id' => $tasks[0]->id,
            'user_id' => $testUser->id,
        ]);
        TaskHistory::factory()->completed()->create([
            'task_id' => $tasks[2]->id,
            'user_id' => $testUser->id,
        ]);
        TaskHistory::factory()->completed()->create([
            'task_id' => $tasks[4]->id,
            'user_id' => $testUser->id,
        ]);

        // Notifications for test user
        Notification::factory(3)->create(['user_id' => $testUser->id]);
        Notification::factory(2)->unread()->create(['user_id' => $testUser->id]);

        // Random tasks for random users
        $randomUsers->each(function ($user) {
            Task::factory(fake()->numberBetween(2, 6))->create([
                'user_id' => $user->id,
            ]);
        });

        $this->command->info('Demo seeder completed successfully.');
        $this->command->info('Admin: admin@listify.com / password');
        $this->command->info('User:  test@listify.com  / password');
    }
}
