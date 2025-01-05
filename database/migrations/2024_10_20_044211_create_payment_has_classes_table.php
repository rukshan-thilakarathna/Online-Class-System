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
        Schema::create('payment_has_classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('class_id');
            $table->string('1')->defult('0');
            $table->string('2')->defult('0');
            $table->string('3')->defult('0');
            $table->string('4')->defult('0');
            $table->string('5')->defult('0');
            $table->string('6')->defult('0');
            $table->string('7')->defult('0');
            $table->string('8')->defult('0');
            $table->string('9')->defult('0');
            $table->string('10')->defult('0');
            $table->string('11')->defult('0');
            $table->string('12')->defult('0');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_has_classes');
    }
};
