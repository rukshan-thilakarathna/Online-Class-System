<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('type')->comment('0-Student / 1-Guardian');
            $table->foreignId('guardian_id')->nullable()->constrained('students')->onDelete('cascade')->comment('Only applicable if type is 1 (Guardian)');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone_number')->nullable();
            $table->string('password');
            $table->string('grade')->nullable();
            $table->string('whatsapp_number')->nullable();
            $table->string('image')->nullable();
            $table->text('address')->nullable();
            $table->date('birthday')->nullable();
            $table->tinyInteger('gender')->comment('0-Male / 1-Female');
            $table->boolean('status')->default(1); // 1 for active, 0 for inactive
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
