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
            $table->bigInteger('faculty_id')->unsigned()->nullable()->after('status');
            $table->foreign('faculty_id')->references('id')->on('faculties')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('inbox', function (Blueprint $table) {
            $table->dropColumn('faculty_id');
            $table->dropForeign(['faculty_id']);
        });
    }
};
