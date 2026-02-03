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
        Schema::table('classrooms', function (Blueprint $table) {
            $table->unique(['school_year_id', 'name']);
        });

        Schema::table('lesson_schedules', function (Blueprint $table) {
            $table->unique(['school_year_id', 'classroom_id', 'day', 'lesson_hour_start', 'lesson_hour_end'], 'unique_lesson_schedule');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('classrooms', function (Blueprint $table) {
            $table->dropUnique(['school_year_id', 'name']);
        });

        Schema::table('lesson_schedules', function (Blueprint $table) {
            $table->dropUnique('unique_lesson_schedule');
        });
    }
};
