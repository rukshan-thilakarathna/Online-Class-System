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
        Schema::create('class_has_tutes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_id')->constrained();
            $table->foreignId('tute_id')->constrained();
            $table->string('status')->default('0');
            $table->numeric('month_number')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_has_tutes');
    }
};
