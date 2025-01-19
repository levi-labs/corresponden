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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('lecturer_id', 15)->nullable();
            $table->string('fullname');
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->string('faculty', 40)->nullable();
            $table->string('degree', 15)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('phone', 22)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('address')->nullable();
            $table->string('image', 60)->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};
