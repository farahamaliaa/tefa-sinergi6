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
        Schema::create('extracurricular_journals', function (Blueprint $table) {
            $table->id();
            $this->addForeignUuid($table, 'extracurricular_id');
            $table->foreignId('schedule_id')->constrained('extracurricular_schedules')->onDelete('cascade');
            $table->date('date');
            $table->text('description');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('extracurricular_journals');
    }
};
