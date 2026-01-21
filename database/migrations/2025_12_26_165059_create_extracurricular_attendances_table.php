<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('extracurricular_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('extracurricular_journal_id')->constrained('extracurricular_journals')->onDelete('cascade');
            $table->foreignId('extracurricular_student_id')->constrained('extracurricular_students')->onDelete('cascade');
            $table->string('status'); // hadir, sakit, izin, alpha
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_attendances');
    }
};
