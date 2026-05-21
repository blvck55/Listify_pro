<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// FILE LOCATION: database/migrations/xxxx_add_role_to_users_table.php
// PURPOSE: Adds a 'role' column to the existing users table
// HOW TO RUN: php artisan migrate

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Adds role column: either 'user' (default) or 'admin'
            $table->enum('role', ['user', 'admin'])->default('user');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
