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
        Schema::create('qand_a_s', function (Blueprint $table) {
            $table->id();
            $table->string('question');
            $table->string('answer_1')->nullable();
            $table->string('answer_2')->nullable();
            $table->string('answer_3')->nullable();
            $table->string('answer_4')->nullable();
            $table->string('answer_5')->nullable();
            $table->string('correct_answer');
            $table->string('type_id')->nullable();
            $table->string('test_id')->nullable();
            $table->string('image')->nullable();
            $table->string('marks')->nullable();
            $table->string('time')->nullable();
            $table->string('status')->default('1');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qand_a_s');
    }
};
