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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject_code');
            $table->string('subject_name');
            $table->string('subject_desc');
            $table->foreignId('default_subject_id')->constrained('default_subjects')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('gr_level_id')->constrained('grade_level')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('sp_freq');
            $table->integer('dp_freq');
            $table->integer('priority_num');
            $table->time('priority_time');
            $table->string('priority_desc');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
