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
        Schema::create('archive_outgoing_letters', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('letter_type_id')->unsigned();
            $table->bigInteger('letter_id')->unsigned()->unsigned()->nullable();
            $table->string('sender', 60)->nullable();
            $table->string('receiver', 60)->nullable();
            $table->string('letter_number', 21);
            $table->date('date');
            $table->enum('source_letter', ['internal', 'external'])->default('external');
            $table->string('subject', 60);
            $table->text('body')->nullable();
            $table->enum('in_archive', ['yes', 'no'])->default('no');
            $table->string('attachment', 120)->nullable();
            $table->timestamps();

            $table->foreign('letter_type_id')->references('id')->on('letter_types')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_outgoing_letters');
    }
};
