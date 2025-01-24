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
        Schema::create('vice_rectors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('faculty_id')->unsigned()->nullable();
            $table->bigInteger('rector_id')->unsigned()->nullable();
            $table->string('vice_rector_id', 15)->nullable();
            $table->string('fullname', 60);
            $table->string('phone', 22)->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('degree', 15)->nullable();
            $table->string('image', 60)->nullable();
            $table->string('email', 60)->nullable();
            $table->string('address')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');
            $table->foreign('rector_id')->references('id')->on('rectors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vice_rectors');
    }
};
