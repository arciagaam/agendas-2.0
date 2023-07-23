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
            $table->string('subject_code')->nullable();
            $table->string('subject_name')->nullable();
            $table->string('subject_description')->nullable();
            $table->foreignId('default_subject_id')->constrained('default_subjects')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreignId('gr_level_id')->constrained('grade_levels')->cascadeOnUpdate()->cascadeOnDelete();
            $table->integer('sp_frequency');
            $table->integer('dp_frequency');
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
