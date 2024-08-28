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
        Schema::create('classes', function (Blueprint $table) {
            $table->string('id'); // Custom string-based primary key
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->string('class_type', 5)->default('1'); // 1=>online, 2=>offline
            $table->string('class_category', 50)->default('1'); // 1=>class, 2=>level
            $table->string('grade', 150); // [1],[2],[3],[4],[5],[6],[7],[8],[9],[10],[11]
            $table->string('class_fees', 50);
            $table->string('class_fees_date', 150); // {"start_date":"2022-01-01","end_date":"2022-01-01"}
            $table->string('class_year', 5);
            $table->string('class_start_date', 50);
            $table->text('class_date'); // {"date":"2022-01-01","time":"10:00:00"},{"date":"2022-01-01","time":"11:00:00"}
            $table->string('status')->default('1'); // 1=>ongoing,2=>completed ,3=>pending
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
