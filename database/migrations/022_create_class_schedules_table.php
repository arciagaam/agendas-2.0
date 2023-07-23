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
        Schema::create('class_schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('classroom_id')->constrained('classrooms')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('subject_teacher_id')->nullable()->constrained('subject_teachers')->cascadeOnUpdate()->cascadeOnDelete();
            // $table->foreignId('school_year_id')->nullable()->constrained('school_year')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('school_year_id')->default(1);
            $table->tinyInteger('timetable');
            $table->foreignId('day_id')->constrained('days')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('period_slot');
            $table->string('time_start');
            $table->string('time_end');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
