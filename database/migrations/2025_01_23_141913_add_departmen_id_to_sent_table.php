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
        Schema::table('sent', function (Blueprint $table) {
            $table->bigInteger('department_id')->unsigned()->nullable()->after('faculty_id');
            $table->foreign('department_id')->references('id')->on('departments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sent', function (Blueprint $table) {
            $table->dropColumn('department_id');
            $table->dropForeign(['department_id']);
        });
    }
};
