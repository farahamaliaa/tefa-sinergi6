<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('student_permissions', function (Blueprint $table) {
            $table->integer('duration')->default(3)->after('date');
        });
    }

    public function down(): void
    {
        Schema::table('student_permissions', function (Blueprint $table) {
            $table->dropColumn('duration');
        });
    }
};
