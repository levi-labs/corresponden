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
        Schema::table('inbox', function (Blueprint $table) {
            $table->bigInteger('sent_id')->unsigned()->nullable();
            $table->foreign('sent_id')->references('id')->on('sent')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inbox', function (Blueprint $table) {
            $table->dropForeign(['sent_id']);
            $table->dropColumn('sent_id');
        });
    }
};
