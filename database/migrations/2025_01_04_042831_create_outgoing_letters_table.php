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
        Schema::create('outgoing_letters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('letter_type_id')->unsigned();
            $table->bigInteger('sender_id')->unsigned();
            $table->bigInteger('receiver_id')->unsigned();
            $table->string('letter_number');
            $table->string('date');
            $table->string('subject');
            $table->text('body');
            $table->string('attachment')->nullable();
            $table->enum('status', ['cancel', 'send', 'unread', 'read', 'reject'])->default('unread');
            $table->timestamps();

            $table->foreign('letter_type_id')->references('id')->on('letter_types')->onDelete('cascade');
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outgoing_letters');
    }
};
