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
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->bigInteger('outgoing_letter_id')->unsigned()->nullable();
            $table->foreign('outgoing_letter_id')->references('id')->on('outgoing_letters')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('incoming_letters', function (Blueprint $table) {
            $table->dropForeign(['outgoing_letter_id']);
            $table->dropColumn('outgoing_letter_id');
        });
    }
};
