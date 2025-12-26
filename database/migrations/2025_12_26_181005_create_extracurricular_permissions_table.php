<?php

use App\Traits\Migrations\HasForeign;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    use HasForeign;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('extracurricular_permissions', function (Blueprint $table) {
            $table->id();
            $this->addForeignUuid($table, 'extracurricular_id');
            $table->foreignId('extracurricular_student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('schedule_id')->nullable()->constrained('extracurricular_schedules')->nullOnDelete();
            $table->date('date');
            $table->enum('type', ['izin', 'sakit'])->default('izin');
            $table->text('reason');
            $table->string('attachment')->nullable(); // For sick letter or proof
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->text('rejection_note')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_permissions');
    }
};
