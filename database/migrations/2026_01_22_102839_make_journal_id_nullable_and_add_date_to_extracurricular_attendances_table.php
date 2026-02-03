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
        Schema::table('extracurricular_attendances', function (Blueprint $table) {
            // Drop foreign key dulu agar bisa dimodifikasi
            $table->dropForeign(['extracurricular_journal_id']);

            // Ubah jadi nullable
            $table->unsignedBigInteger('extracurricular_journal_id')->nullable()->change();

            // Tambahkan kolom date
            $table->date('date')->nullable()->after('extracurricular_student_id');

            // Kembalikan foreign key
            $table->foreign('extracurricular_journal_id')
                ->references('id')
                ->on('extracurricular_journals')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('extracurricular_attendances', function (Blueprint $table) {
            $table->dropForeign(['extracurricular_journal_id']);

            // Perlu update data null dulu kalau mau revert ke not null, tapi di down() ini tricky.
            // Kita asumsikan revert structure-nya saja.

            $table->unsignedBigInteger('extracurricular_journal_id')->nullable(false)->change();
            $table->dropColumn('date');

            $table->foreign('extracurricular_journal_id')
                ->references('id')
                ->on('extracurricular_journals')
                ->onDelete('cascade');
        });
    }
};
