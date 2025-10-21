<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\StudentDisciplinaryActionsEnum;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('student_disciplinary_actions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_membership_id')->constrained()->cascadeOndelete();
            $table->enum('action_type', array_column(StudentDisciplinaryActionsEnum::cases(), 'value'));
            $table->integer('point')->default(0);
            $table->text('proof')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->foreignId('regulation_id')->nullable()->constrained()->nullOnDelete();
            $table->boolean('is_approved')->default(false);                       
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_disciplinary_actions');
    }
};
