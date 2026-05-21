<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('task_histories', function (Blueprint $table) {
            $table->foreignId('task_id')->after('id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->after('task_id')->constrained()->onDelete('cascade');
            $table->string('action')->after('user_id');
            $table->string('old_status')->nullable()->after('action');
            $table->string('new_status')->nullable()->after('old_status');
            $table->timestamp('changed_at')->useCurrent()->after('new_status');
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
