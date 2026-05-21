<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained()->onDelete('cascade');
            }
            if (!Schema::hasColumn('categories', 'name')) {
                $table->string('name', 50)->after('user_id');
            }
            if (!Schema::hasColumn('categories', 'colour')) {
                $table->string('colour', 7)->default('#3B82F6')->after('name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            if (Schema::hasColumn('categories', 'user_id')) {
                $table->dropForeignIdFor(\App\Models\User::class);
                $table->dropColumn('user_id');
            }
            if (Schema::hasColumn('categories', 'name')) {
                $table->dropColumn('name');
            }
            if (Schema::hasColumn('categories', 'colour')) {
                $table->dropColumn('colour');
            }
        });
    }
};
