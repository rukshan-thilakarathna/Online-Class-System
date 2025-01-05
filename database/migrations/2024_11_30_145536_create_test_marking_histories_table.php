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
        Schema::create('test_marking_histories', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('test_id');
            $table->string('Qanda_id');
            $table->string('Correct_answer');
            $table->string('student_answer');
            $table->string('marks');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_marking_histories');
    }
};
