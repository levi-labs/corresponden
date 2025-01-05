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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->string('fullname');
            $table->date('date_of_birth')->nullable();
            $table->string('hobby')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('student_id')->unique();
            $table->string('year_enrolled')->nullable();
            $table->string('year_graduated')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
