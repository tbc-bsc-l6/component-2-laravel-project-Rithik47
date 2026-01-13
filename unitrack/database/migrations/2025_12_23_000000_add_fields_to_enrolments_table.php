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
        Schema::table('enrolments', function (Blueprint $table) {
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('module_id')->constrained('modules')->cascadeOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->enum('status', ['pending', 'pass', 'fail'])->default('pending');
            $table->timestamp('completed_at')->nullable();

            $table->unique(['user_id', 'module_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('enrolments', function (Blueprint $table) {
            $table->dropUnique(['user_id', 'module_id']);
            $table->dropColumn(['user_id', 'module_id', 'started_at', 'status', 'completed_at']);
        });
    }
};
