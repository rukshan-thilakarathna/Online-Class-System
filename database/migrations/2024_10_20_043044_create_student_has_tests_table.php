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
        Schema::create('student_has_tests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained();
            $table->foreignId('test_id')->constrained();
            $table->foreignId('class_id')->constrained();
            $table->string('full_marks')->default('0');
            $table->string('get_marks')->default('0');
            $table->string('start_time')->default('0');
            $table->string('end_time')->default('0');
            $table->string('marks_percentage')->default('0');
            $table->string('status')->default('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_has_tests');
    }
};
