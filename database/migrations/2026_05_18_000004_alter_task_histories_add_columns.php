<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_histories', function (Blueprint $table) {
            if (! Schema::hasColumn('task_histories', 'task_id')) {
                $table->foreignId('task_id')->after('id')->constrained()->onDelete('cascade');
            }
            if (! Schema::hasColumn('task_histories', 'user_id')) {
                $table->foreignId('user_id')->after('task_id')->constrained()->onDelete('cascade');
            }
            if (! Schema::hasColumn('task_histories', 'action')) {
                $table->string('action')->after('user_id');
            }
            if (! Schema::hasColumn('task_histories', 'old_status')) {
                $table->string('old_status')->nullable()->after('action');
            }
            if (! Schema::hasColumn('task_histories', 'new_status')) {
                $table->string('new_status')->nullable()->after('old_status');
            }
            if (! Schema::hasColumn('task_histories', 'changed_at')) {
                $table->timestamp('changed_at')->useCurrent()->after('new_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('task_histories', function (Blueprint $table) {
            $table->dropForeignIdFor(\App\Models\Task::class);
            $table->dropForeignIdFor(\App\Models\User::class);
            $table->dropColumn(['action', 'old_status', 'new_status', 'changed_at']);
        });
    }
};
