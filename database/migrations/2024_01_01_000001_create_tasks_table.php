<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// FILE LOCATION: database/migrations/xxxx_create_tasks_table.php
// HOW TO RUN:    php artisan migrate

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();                                    // Auto-increment ID (Primary Key)

            $table->foreignId('user_id')                    // Links task to a user
                  ->constrained()                           // References users.id automatically
                  ->onDelete('cascade');                    // Delete tasks if user is deleted

            $table->string('title');                        // Task title (required)
            $table->string('subtitle')->nullable();         // Optional subtitle
            $table->text('description')->nullable();        // Optional description
            $table->date('due_date')->nullable();           // When is it due?

            $table->enum('priority', ['low', 'medium', 'high'])
                  ->default('low');                         // Priority level

            $table->enum('status', ['pending', 'completed'])
                  ->default('pending');                     // Current status

            $table->timestamps();                           // created_at, updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
