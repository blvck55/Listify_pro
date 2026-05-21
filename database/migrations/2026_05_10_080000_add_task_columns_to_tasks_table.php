<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('tasks')) {
            return;
        }

        Schema::table('tasks', function (Blueprint $table) {
            if (! Schema::hasColumn('tasks', 'title')) {
                $table->string('title');
            }

            if (! Schema::hasColumn('tasks', 'subtitle')) {
                $table->string('subtitle')->nullable();
            }

            if (! Schema::hasColumn('tasks', 'description')) {
                $table->text('description')->nullable();
            }

            if (! Schema::hasColumn('tasks', 'due_date')) {
                $table->date('due_date')->nullable();
            }

            if (! Schema::hasColumn('tasks', 'priority')) {
                $table->enum('priority', ['low', 'medium', 'high'])->default('low');
            }

            if (! Schema::hasColumn('tasks', 'status')) {
                $table->enum('status', ['pending', 'completed'])->default('pending');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('tasks')) {
            return;
        }

        Schema::table('tasks', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('tasks', 'status')) {
                $columns[] = 'status';
            }

            if (Schema::hasColumn('tasks', 'priority')) {
                $columns[] = 'priority';
            }

            if (Schema::hasColumn('tasks', 'due_date')) {
                $columns[] = 'due_date';
            }

            if (Schema::hasColumn('tasks', 'description')) {
                $columns[] = 'description';
            }

            if (Schema::hasColumn('tasks', 'subtitle')) {
                $columns[] = 'subtitle';
            }

            if (Schema::hasColumn('tasks', 'title')) {
                $columns[] = 'title';
            }

            if (! empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
