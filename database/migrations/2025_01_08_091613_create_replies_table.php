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
        Schema::create('replies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_letter');
            $table->unsignedBigInteger('inbox_id');
            $table->text('greeting')->nullable();
            $table->text('closing')->nullable();
            $table->string('file', 60)->nullable();
            $table->foreign('id_letter')->references('id')->on('inbox')->onDelete('restrict');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('replies');
    }
};
