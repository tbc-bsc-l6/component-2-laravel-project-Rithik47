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
        Schema::table('modules', function (Blueprint $table) {
            if (!Schema::hasColumn('modules', 'code')) {
                $table->string('code')->unique()->after('id');
            }

            if (!Schema::hasColumn('modules', 'name')) {
                $table->string('name')->after('code');
            }

            if (!Schema::hasColumn('modules', 'is_archived')) {
                $table->boolean('is_archived')->default(false)->after('name');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            if (Schema::hasColumn('modules', 'is_archived')) {
                $table->dropColumn('is_archived');
            }

            if (Schema::hasColumn('modules', 'name')) {
                $table->dropColumn('name');
            }

            if (Schema::hasColumn('modules', 'code')) {
                $table->dropUnique(['code']);
                $table->dropColumn('code');
            }
        });
    }
};