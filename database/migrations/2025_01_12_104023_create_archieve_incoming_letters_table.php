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
        Schema::create('archieve_incoming_letters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('incoming_letter_id')->unsigned()->nullable();
            $table->bigInteger('receiver_id')->unsigned()->nullable();
            $table->bigInteger('sender_id')->unsigned()->nullable();
            $table->string('sender_name', 60);
            $table->string('receiver_name', 60);
            $table->string('subject', 60);
            $table->text('body');
            $table->string('latter_number', 60);
            $table->string('attachment')->nullable();
            $table->date('date');
            $table->foreign('incoming_letter_id')->references('id')->on('incoming_letters')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('restrict');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archieve_incoming_letters');
    }
};
