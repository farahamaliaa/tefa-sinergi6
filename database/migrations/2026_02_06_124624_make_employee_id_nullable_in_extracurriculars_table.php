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
        Schema::table('extracurriculars', function (Blueprint $table) {
            // Drop the existing foreign key constraint first
            $table->dropForeign(['employee_id']);
            
            // Modify the column to be nullable
            $table->unsignedBigInteger('employee_id')->nullable()->change();
            
            // Re-add the foreign key constraint
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extracurriculars', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['employee_id']);
            
            // Revert to non-nullable (only if no null values exist)
            $table->unsignedBigInteger('employee_id')->nullable(false)->change();
            
            // Re-add the foreign key constraint
            $table->foreign('employee_id')
                ->references('id')
                ->on('employees')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();
        });
    }
};
