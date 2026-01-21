<?php

use App\Enums\PermissionTypeEnum;
use App\Enums\StatusPermissionEnum;
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
        Schema::create('student_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->uuid('classroom_id')->nullable()->constrained()->nullOnDelete();
            $table->enum('permission_type', array_column(PermissionTypeEnum::cases(), 'value'));
            $table->text('proof')->nullable();
            $table->text('proof_image')->nullable();
            $table->foreignId('submitted_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->enum('status', array_column(StatusPermissionEnum::cases(), 'value'));
            $table->date('date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_permissions');
    }
};
